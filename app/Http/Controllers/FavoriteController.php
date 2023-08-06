<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            // Add any other fields that need validation here
        ]);

        $favorite = Favorite::create($validatedData);

        return response()->json(['message' => 'Location added to favorites', 'data' => $favorite], 201);
    }

    public function destroy($id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();

        return response()->json(['message' => 'Location removed from favorites']);
    }
}
