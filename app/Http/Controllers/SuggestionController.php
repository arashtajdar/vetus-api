<?php

namespace App\Http\Controllers;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'suggestion' => 'required|string',
            // Add any other fields that need validation here
        ]);

        $suggestion = Suggestion::create($validatedData);

        return response()->json(['message' => 'Suggestion created successfully', 'data' => $suggestion], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'location_id' => 'required|exists:locations,location_id',
            'suggestion' => 'required|string',
            // Add any other fields that need validation here
        ]);

        $suggestion = Suggestion::findOrFail($id);
        $suggestion->update($validatedData);

        return response()->json(['message' => 'Suggestion updated successfully', 'data' => $suggestion]);
    }

    public function destroy($id)
    {
        $suggestion = Suggestion::findOrFail($id);
        $suggestion->delete();

        return response()->json(['message' => 'Suggestion deleted successfully']);
    }
}
