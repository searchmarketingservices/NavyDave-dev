<?php

namespace App\Http\Controllers;

use App\Models\PackageLogs;
use App\Models\UserPackage;
use Illuminate\Http\Request;
use App\Models\Service;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Session;
use App\Models\UserSession;
use App\Models\Staff;
use App\Models\Discount;
use App\Models\Payment;

class UserPackageController extends Controller
{
    public function packages()
    {
        return view('dashboard.user.package.index');
    }
    public function show()
    {
        $today = now();
        $services = Service::with('category')->where('is_admin',0)->get();
        foreach ($services as $s) {
            $discount = Discount::where('status', 1)
                ->where('service_id', $s->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('expired_date', '>=', $today)
                ->first();

            if ($discount) {
                $s->is_discount = true;
                $s->discount = $discount->percentage;
                $s->original_price = $s->price;
                $s->price = $s->price - ($s->price * $discount->percentage / 100);
            } else {
                $s->is_discount = false;
                $s->discount = 0;
                $s->original_price = $s->price;
            }
        }
        return response()->json(['services' => $services]);
    }
    public function buy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id',
            'email' => 'email',
        ]);

        $today = now();
        $service = Service::find($request->id);
        $discount = Discount::where('status', 1)
            ->where('service_id', $service->id)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('expired_date', '>=', $today)
            ->first();

        if ($discount) {
            $service->is_discount = true;
            $service->discount = $discount->percentage;
            $service->original_price = $service->price;
            $service->price = $service->price - ($service->price * $discount->percentage / 100);
        } else {
            $service->is_discount = false;
            $service->discount = 0;
            $service->original_price = $service->price;
        }


        $email = $request->email;

        // // Check if the user already has an active package for this service
        // $existingPackage = UserPackage::where('user_id', auth()->user()->id)
        //     ->where('service_id', $service->id)
        //     ->where('status', 'active')
        //     ->first();

        // if ($existingPackage) {
        //     // User already has an active package for this service, return an error
        //     return redirect()->route('user.packages')->with('error', 'You already have an active package for this service. No need to buy again.');
        // }

        $stripeSecretKey = env('STRIPE_SECRET_KEY', 'sk_test_51LkfAQH65lvSBiDK232wi93QAEfeM0XgS8s62kRse0LGoKn2pHxZhMu23pA4w5CyqeR7jaichrCsgnSQdz5S7NPD00GOpROogE');
        $stripe = new StripeClient([
            'api_key' => $stripeSecretKey,
        ]);

        $checkoutSession = $stripe->checkout->sessions->create([
            'success_url' => route('user.payment.success'),
            'cancel_url' => route('user.payment.fail'),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'USD',
                        'unit_amount' => $service->price * 100,
                        'product_data' => [
                            'name' => $service->name,
                            'description' => 'Service charge',
                        ],
                    ],
                    'quantity' => 1,
                ],
            ],
            'customer_email' => $email,
        ]);

        Session::put('stripe_checkout_id', $checkoutSession->id);
        Session::put('service_id_for_by_package', $service->id);

        return redirect()->away($checkoutSession->url);
    }


    public function success()
    {
        $stripeCheckoutId = Session::get('stripe_checkout_id');
        $service_id_for_by_package = Session::get('service_id_for_by_package');

        $stripe = new StripeClient(['api_key' => env('STRIPE_SECRET_KEY')]);
        $stripeSession = $stripe->checkout->sessions->retrieve($stripeCheckoutId);

        if ($stripeSession->payment_status === 'paid') {
            $service = Service::find($service_id_for_by_package);

            $today = now();

            $discount = Discount::where('status', 1)
                ->where('service_id', $service->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('expired_date', '>=', $today)
                ->first();

            if ($discount) {
                $service->is_discount = true;
                $service->discount = $discount->percentage;
                $service->original_price = $service->price;
                $service->price = $service->price - ($service->price * $discount->percentage / 100);
            } else {
                $service->is_discount = false;
                $service->discount = 0;
                $service->original_price = $service->price;
            }

            // Check if the user already has an active package for this service
            // $existingPackage = UserPackage::where('user_id', auth()->user()->id)
            //     ->where('service_id', $service->id)
            //     ->where('status', 'active')
            //     ->first();

            // if ($existingPackage) {
            //     return redirect()->route('user.packages')->with('error', 'You already have an active package for this service');
            // }

            // Create the new package
            $package = UserPackage::create([
                'user_id' => auth()->user()->id,
                'service_id' => $service->id,
                'sessions' => $service->slots,
                'used_sessions' => 0,
                'status' => 'active',
                'is_free' => 0,
            ]);

            $staff = Staff::where('status', 'Active')->first();
            // Update the UserSession table with the new package's sessions
            $userSession = UserSession::where('user_id', auth()->user()->id)->first();
            if ($userSession) {
                $userSession->sessions += $service->slots;  // Add the slots from the purchased package
                $userSession->save();
            } else {
                // If no UserSession exists, create a new one
                UserSession::create([
                    'user_id' => auth()->user()->id,
                    'sessions' => $service->slots,  // Add slots directly from the package
                    'service_id' => $service->id,
                    'staff_id' => $staff->id,
                ]);
            }

            // Log the purchase
            PackageLogs::create([
                'user_id' => auth()->user()->id,
                'package_id' => $package->id,
                'action_type' => 'purchase',
                'slots_used' => $package->used_sessions,
                'amount_paid' => $service->price,
            ]);

            Payment::create([
                'user_id' => auth()->user()->id,
                'package_id' => $package->id,
                'payment_id' => $stripeSession->payment_intent, // Payment Intent ID
                'amount' => $stripeSession->amount_total, // Total amount in cents
                'currency' => $stripeSession->currency, // Currency
                'status' => $stripeSession->payment_status, // Payment status (e.g., 'paid')
            ]);
            

            
            return view('guest.packageBuySuccess');
            // return redirect()->route('user.packages')->with('success', 'Payment successful');
        } else {
            return redirect()->route('user.payment.fail')->with('error', 'Payment failed');
        }
    }

    public function paymentfail()
    {
        return redirect()->route('user.packages')->with('error', 'Payment failed');
    }
    public function myPackages()
    {
        $userId = auth()->user()->id;

        // Fetch user packages
        $packages = UserPackage::where('user_id', $userId)
            ->with('service')
            ->orderBy('id', 'desc')
            ->get();

        // Prepare package data
        $data = $packages->map(function ($package) {
            return [
                'package_id' => $package->id,
                'service_name' => $package->service->   name ?? 'Unknown Service',
                'sessions' => $package->sessions,
                'used_sessions' => $package->used_sessions,
                'status' => $package->status, // active/inactive
                'is_free' => $package->is_free ?? false, // Check if free
                'can_upgrade' => $package->used_sessions < $package->sessions, // Show upgrade button if incomplete
            ];
        });

        return view('dashboard.user.package.my-packages', compact('data'));
    }
    public function userPackages()
    {
        // Fetch user packages
        $packages = UserPackage::with([
            'user' => function ($query) {
                $query->withTrashed(); // Include soft-deleted users
            },
            'service',
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Prepare package data
        $data = $packages->map(function ($package) {
            return [
                'package_id' => $package->id,
                'user_id' => $package->user_id,
                'user_name' => $package->user->name . ' ' . $package->user->last_name ?? 'Unknown User',
                'user_email' => $package->user->email ?? 'Unknown Email',
                'service_name' => $package->service->name ?? 'Unknown Service',
                'sessions' => $package->sessions,
                'used_sessions' => $package->used_sessions,
                'status' => $package->status, // active/inactive
                'is_free' => $package->is_free ?? false, // Check if free
                'can_upgrade' => $package->used_sessions < $package->sessions, // Show upgrade button if incomplete
                'is_deleted' => $package->user ? ($package->user->deleted_at ? true : false) : null, // Check soft-delete
            ];
        });

        return view('dashboard.admin.package.index', compact('data'));
    }



}
