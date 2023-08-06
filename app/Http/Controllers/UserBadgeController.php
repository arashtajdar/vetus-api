<?php

namespace App\Http\Controllers;
use App\Models\UserBadge;
use Illuminate\Http\Request;

class UserBadgeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        $userBadges = UserBadge::paginate($perPage);

        return $userBadges;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Replace 'users' with your actual users table name
            'badge_name' => 'required|string|max:255',
            // Add any other fields that need validation here
        ]);

        $userBadge = UserBadge::create($validatedData);

        return response()->json(['message' => 'User badge created successfully', 'data' => $userBadge], 201);
    }

    public function show($id)
    {
        $userBadge = UserBadge::findOrFail($id);

        return $userBadge;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id', // Replace 'users' with your actual users table name
            'badge_name' => 'required|string|max:255',
            // Add any other fields that need validation here
        ]);

        $userBadge = UserBadge::findOrFail($id);
        $userBadge->update($validatedData);

        return response()->json(['message' => 'User badge updated successfully', 'data' => $userBadge]);
    }

    public function destroy($id)
    {
        $userBadge = UserBadge::findOrFail($id);
        $userBadge->delete();

        return response()->json(['message' => 'User badge deleted successfully']);
    }
}
