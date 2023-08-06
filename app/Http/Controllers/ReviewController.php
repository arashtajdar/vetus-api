<?php

namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
            // Add any other fields that need validation here
        ]);

        $review = Review::create($validatedData);

        return response()->json(['message' => 'Review created successfully', 'data' => $review], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
            // Add any other fields that need validation here
        ]);

        $review = Review::findOrFail($id);
        $review->update($validatedData);

        return response()->json(['message' => 'Review updated successfully', 'data' => $review]);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
