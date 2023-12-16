<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        // If a token is provided, $user will contain the authenticated user.
        // If no token is provided or the token is invalid, $user will be null.

        $perPage = 5000;
        return Location::with(["favorites" => function ($query) use ($user) {
            $query->where('user_id', $user?->getAttributes()["id"]);
        }])->with(["reviews" => function ($query) use ($user) {
            $query->where('user_id', $user?->getAttributes()["id"]);
        }])->paginate($perPage);
    }

    public function find(Request $request)
    {
        $perPage = 5000;

        $visibleRegionData = $request->input('visible_region_data');
        if ($visibleRegionData) {
            $latitude = $visibleRegionData['latitude'];
            $longitude = $visibleRegionData['longitude'];
            $latitudeDelta = $visibleRegionData['latitudeDelta'];
            $longitudeDelta = $visibleRegionData['longitudeDelta'];

            $locations = Location::with('category')
                ->whereBetween('latitude', [$latitude - $latitudeDelta, $latitude + $latitudeDelta])
                ->whereBetween('longitude', [$longitude - $longitudeDelta, $longitude + $longitudeDelta])
                ->paginate($perPage);
        } else {
            $locations = Location::with('category')->paginate($perPage);
        }

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
