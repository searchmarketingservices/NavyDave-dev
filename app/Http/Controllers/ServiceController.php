<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.service.index');
    }

    public function create()
    {
        $category =Category::get(['id','name']);

        return view('dashboard.admin.service.create', compact('category'));
    }
    public function store(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'image' => 'nullable|image|max:4048|mimes:jpg,jpeg,png,webp',
        'name' => 'required|string|max:255',
        'category_id' => 'nullable|integer',
        'price' => 'required|numeric',
        'duration' => 'required|integer',
        'type_duration' => 'required|in:mins,hours,days',
        'buffer_time_before' => 'nullable|integer',
        'type_buffer_time_before' => 'nullable|in:mins,hours',
        'buffer_time_after' => 'nullable|integer',
        'type_buffer_time_after' => 'nullable|in:mins,hours',
        'min_capacity' => 'required|integer',
        'max_capacity' => 'required|integer',
        'description' => 'nullable|string',
        'slots' => 'required|string|min:1|max:1000',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $extension = $request->file('image')->getClientOriginalExtension();
        $uniqueName = 'service' . Str::random(40) . '.' . $extension;
        $request->file('image')->storeAs('public', $uniqueName);
        $validated['image'] = $uniqueName;
    } else {
        // Use the default image
        $validated['image'] = 'default.png';
    }

    // Create the service
    Service::create($validated);

    // Redirect or return a response
    return redirect()->route('admin.service')->with('success', 'Service created successfully.');
}

public function show(){

       $services = Service::with('category')->get();

    return response()->json(['services' => $services]);
}
public function edit($id){

    $service = Service::find($id);
    $categories =Category::get(['id','name']);
    return view('dashboard.admin.service.edit', compact('service','categories'));
}
public function update(Request $request, $id)
{
    try {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|integer',
            'type_duration' => 'nullable|string',
            'buffer_time_before' => 'nullable|integer',
            'type_buffer_time_before' => 'nullable|string',
            'buffer_time_after' => 'nullable|integer',
            'type_buffer_time_after' => 'nullable|string',
            'min_capacity' => 'nullable|integer',
            'max_capacity' => 'nullable|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4048',
            'slots' => 'nullable|string|min:1|max:1000',
        ]);

        // Find the service record by ID
        $service = Service::findOrFail($id);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($service->image) {
                $oldImagePath = storage_path('app/public/' . $service->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            // $imagePath = $request->file('image')->store('public/services');
            // $finalPath = explode('public/', $imagePath)[1];
            // $validated['image'] = $finalPath;

            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueName = 'service' . Str::random(40) . '.' . $extension;
            $request->file('image')->storeAs('public', $uniqueName);
            $validated['image'] = $uniqueName;
        }

        // Update the service entry with new information
        $service->update([
            'name' => $validated['name'] ?? $service->name,
            'category_id' => $validated['category_id'] ?? $service->category_id,
            'price' => $validated['price'] ?? $service->price,
            'duration' => $validated['duration'] ?? $service->duration,
            'slots' => $validated['slots'] ?? $service->slots,
            'type_duration' => $validated['type_duration'] ?? $service->type_duration,
            'buffer_time_before' => $validated['buffer_time_before'] ?? $service->buffer_time_before,
            'type_buffer_time_before' => $validated['type_buffer_time_before'] ?? $service->type_buffer_time_before,
            'buffer_time_after' => $validated['buffer_time_after'] ?? $service->buffer_time_after,
            'type_buffer_time_after' => $validated['type_buffer_time_after'] ?? $service->type_buffer_time_after,
            'min_capacity' => $validated['min_capacity'] ?? $service->min_capacity,
            'max_capacity' => $validated['max_capacity'] ?? $service->max_capacity,
            'description' => $validated['description'] ?? $service->description,
            'image' => $validated['image'] ?? $service->image,
        ]);

        return redirect()->route('admin.service')->with('success', 'Service updated successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }
}

public function destroy($id)
{
    $service = Service::find($id);
    $service->delete();
    return response()->json(['success' => true]);
}

public function storeCategory(Request $request)
{
    $request->validate([
        'name' => 'nullable|string|max:255',
    ]);

    $category = Category::create([
        'name' => $request->name,
    ]);

    return response()->json(['success' => true, 'category' => $category]);
}

}
