<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceAssign as ModelsServiceAssign;
use App\Models\Staff;
use Illuminate\Http\Request;

class ServiceAssign extends Controller
{
 public function index()
 {
    $staff = Staff::with('user')->get();
    $services = Service::get(['id','name']);
     return view('dashboard.admin.service-assign.index',compact('staff','services'));
 }

 public function store(Request $request)
    {
        $request->validate([
            'staff' => 'required|exists:staff,id',
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
        ]);

        $staffId = $request->input('staff');
        $serviceIds = $request->input('service_ids');

        foreach ($serviceIds as $serviceId) {
           $create= new ModelsServiceAssign();
           $create->staff_id = $staffId;
           $create->service_id = $serviceId;
           $create->save();
        }

        return response()->json(['success' => 'Service assigned successfully!']);
    }

    public function show(){

        $services = \App\Models\ServiceAssign::with('service','staff.user')->get();

       return response()->json(['services' => $services]);
    }

    public function destroy($id)
    {
        $service = \App\Models\ServiceAssign::where('staff_id',$id)->get();
        foreach($service as $s){
            $s->delete();
        }
        return response()->json(['success' => 'Service deleted successfully!']);
    }

    // ServiceAssignController.php
    public function edit($id)
{
    try {
        $serviceAssign = \App\Models\ServiceAssign::with(['staff.user', 'service'])->findOrFail($id);
        return response()->json(['service' => $serviceAssign]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['error' => 'Service assignment not found.'], 404);
    }
}

public function update(Request $request, $id)
{
    $serviceAssign = ModelsServiceAssign::findOrFail($id);
    $serviceAssign->service_id = $request->service_id;
    $serviceAssign->save();

    return response()->json(['success' => 'Service assignment updated successfully']);
}


}
