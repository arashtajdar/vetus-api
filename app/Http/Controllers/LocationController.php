<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        $locations = Location::with('category')->paginate($perPage);

        return $locations;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'category_id' => 'required|exists:categories,category_id',
// Add any other fields that need validation here
        ]);

        $location = Location::create($validatedData);

        return response()->json(['message' => 'Location created successfully', 'data' => $location], 201);
    }

    public function show($id)
    {
        $location = Location::with(['category', 'locationImages', 'reviews', 'favorites', 'suggestions'])->findOrFail($id);

        return $location;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'category_id' => 'required|exists:categories,category_id',
// Add any other fields that need validation here
        ]);

        $location = Location::findOrFail($id);
        $location->update($validatedData);

        return response()->json(['message' => 'Location updated successfully', 'data' => $location]);
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return response()->json(['message' => 'Location deleted successfully']);
    }
}
