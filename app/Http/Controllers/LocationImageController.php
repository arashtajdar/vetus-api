<?php

namespace App\Http\Controllers;
// app/Http/Controllers/LocationImageController.php
use App\Models\LocationImage;
use Illuminate\Http\Request;

class LocationImageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'image_url' => 'required|url',
            // Add any other fields that need validation here
        ]);

        $locationImage = LocationImage::create($validatedData);

        return response()->json(['message' => 'Location image created successfully', 'data' => $locationImage], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'image_url' => 'required|url',
            // Add any other fields that need validation here
        ]);

        $locationImage = LocationImage::findOrFail($id);
        $locationImage->update($validatedData);

        return response()->json(['message' => 'Location image updated successfully', 'data' => $locationImage]);
    }

    public function destroy($id)
    {
        $locationImage = LocationImage::findOrFail($id);
        $locationImage->delete();

        return response()->json(['message' => 'Location image deleted successfully']);
    }
}
