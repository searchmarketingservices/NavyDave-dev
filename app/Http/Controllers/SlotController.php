<?php

namespace App\Http\Controllers;

use App\Models\ServiceAssign;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Slot;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('staff.user', 'service')->get();
        return view('dashboard.admin.slot.index', compact('slots'));
    }

    public function create()
    {
        $staff = Staff::all();
        $services = Service::all();
        return view('dashboard.admin.slot.create', compact('staff', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'service_id' => 'required|exists:services,id',
            'available_on' => 'required|string',
            'available_from' => 'required|date_format:H:i', // 24-hour format
            'available_to' => 'required|date_format:H:i',   // 24-hour format
        ]);
        $slot = new Slot();
        $slot->available_from = \Carbon\Carbon::createFromFormat('H:i', $request->available_from)->format('H:i:s');
        $slot->available_to = \Carbon\Carbon::createFromFormat('H:i', $request->available_to)->format('H:i:s');
        $slot->staff_id = $request->staff_id;
        $slot->service_id = $request->service_id;
        $slot->available_on = $request->available_on;
        $slot->save();
        return redirect('/admin/slot')->with('success', 'Slot created successfully.');
    }


    public function edit($id)
    {
        $slot = Slot::findOrFail($id);
        $staff = Staff::all(); // Assuming you have a Staff model
        $services = Service::all(); // Assuming you have a Service model

        return view('dashboard.admin.slot.edit', compact('slot', 'staff', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'service_id' => 'required|exists:services,id',
            'available_on' => 'required|string',
            'available_from' => 'required|date_format:H:i', // 24-hour format
            'available_to' => 'required|date_format:H:i',   // 24-hour format
        ]);

        $slot = Slot::findOrFail($id);

        // Convert available_from and available_to to 24-hour format with seconds
        $slot->available_from = \Carbon\Carbon::createFromFormat('H:i', $request->available_from)->format('H:i:s');
        $slot->available_to = \Carbon\Carbon::createFromFormat('H:i', $request->available_to)->format('H:i:s');

        // Update other fields
        $slot->staff_id = $request->staff_id;
        $slot->service_id = $request->service_id;
        $slot->available_on = $request->available_on;

        $slot->save();

        return redirect()->route('admin.slot')->with('success', 'Slot updated successfully.');
    }

    public function destroy($id)
    {
        Slot::find($id)->delete();
        return redirect()->route('admin.slot')->with('success', 'Slot deleted successfully.');
    }
    public function getServices(Request $request)
    {
        $serviceIds = ServiceAssign::where('staff_id', $request->staff_id)->pluck('service_id');
        $services = Service::whereIn('id', $serviceIds)->get();
        return response()->json($services);
    }
}
