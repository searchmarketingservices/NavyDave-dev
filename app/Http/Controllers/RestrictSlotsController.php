<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RestrictSlot;

class RestrictSlotsController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.restrict-slots.index');
    }
    public function get()
    {
        $restrict_slot = RestrictSlot::all();
        return response()->json([
            'success' => true,
            'message' => 'Restrict Slots Get Successfully!',
            'data' => $restrict_slot,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:restrict_slots,date',
        ]);

        $restrict_slot = new RestrictSlot;
        $restrict_slot->date = $request->date;
        $restrict_slot->save();
        return response()->json([
            'success' => true,
            'message' => 'Restrict Slots Created Successfully!',
            'data' => $restrict_slot,
        ]);
    }
    public function edit($id)
    {
        $restrict_slot = RestrictSlot::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Restrict Slots Created Successfully!',
            'data' => $restrict_slot,
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'date' => 'required|date|unique:restrict_slots,date,' . $request->id,
        ]);

        $restrict_slot = RestrictSlot::findOrFail($request->id);
        $restrict_slot->date = $request->date;
        $restrict_slot->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Restrict Slots Updated Successfully!',
            'data' => $restrict_slot,
        ]);
        
    }
    public function delete($id)
    {
        $restrict_slot = RestrictSlot::findOrFail($id);
        $restrict_slot->delete();
        return response()->json([
            'success' => true,
            'message' => 'Restrict Slots Deleted Successfully!',
        ]);
    }
}
