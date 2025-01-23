<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with('service')->get();
        $services = Service::get();
        return view('dashboard.admin.discount.index', compact("discounts", "services"));
    }
    public function getData()
    {
        $discounts = Discount::with('service')->get();
        $services = Service::get();
        return response()->json(['discounts' => $discounts, 'services' => $services]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'expired_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
        ]);

        $existingDiscount = Discount::where('service_id', $request->service_id)
            ->where('expired_date', '>=', now())
            ->first();

        if ($existingDiscount) {
            return response()->json([
                'success' => false,
                'message' => 'Discount already exists for this service.',
            ]);
        }

        $discount = new Discount();
        $discount->service_id = $request->service_id;
        $discount->percentage = $request->percentage;
        $discount->start_date = $request->start_date;
        $discount->expired_date = $request->expired_date;
        $discount->status = $request->status;
        $discount->save();

        return response()->json([
            'success' => true,
            'message' => 'Discount created successfully!',
            'discount' => $discount,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'expired_date' => 'required|date|after:start_date',
            'status' => 'required|boolean',
        ]);

        $existingDiscount = Discount::where('service_id', $request->service_id)
            ->where('expired_date', '>=', now())
            ->where('id', '!=', $request->id)
            ->first();

        if ($existingDiscount) {
            return response()->json([
                'success' => false,
                'message' => 'Discount already exists for this service.',
            ]);
        }

        $discount = Discount::find($request->id);
        $discount->service_id = $request->service_id;
        $discount->percentage = $request->percentage;
        $discount->start_date = $request->start_date;
        $discount->expired_date = $request->expired_date;
        $discount->status = $request->status;
        $discount->save();

        return response()->json([
            'success' => true,
            'message' => 'Discount updated successfully!',
            'discount' => $discount,
        ]);
    }

    public function duplicate($id)
    {
        try {
            // Find the original discount record by ID
            $originalDiscount = Discount::findOrFail($id);

            // Create a duplicate with the same data
            $newDiscount = $originalDiscount->replicate(); // Duplicates the model without ID
            $newDiscount->created_at = now(); // Update timestamps for the new record
            $newDiscount->updated_at = now();
            $newDiscount->save();

            return response()->json([
                'success' => true,
                'message' => 'Discount duplicated successfully!',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Discount not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while duplicating the discount.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $discount = Discount::find($id);
        $discount->delete();
        return response()->json([
            'success' => true,
            'message' => 'Discount deleted successfully!',
        ]);
    }
}
