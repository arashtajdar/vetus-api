<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'location_id' => 'required|exists:locations,id'
            ]);
            $validatedData["user_id"] = $request->user()->getAttributes()["id"];
            $favorite = Favorite::create($validatedData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating favorite', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Location added to favorites', 'data' => $favorite], 201);
    }

    public function destroy(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'location_id' => 'required|exists:locations,id'
            ]);
            $validatedData["user_id"] = $request->user()->getAttributes()["id"];
            $favorite = Favorite::where("location_id" , $validatedData["location_id"])->where("user_id", $validatedData["user_id"]);
            $favorite->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error removing favorite', 'error' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Location removed from favorites'], 201);
    }
}
