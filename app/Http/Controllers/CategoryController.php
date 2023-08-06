<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;

        $categories = Category::with('locations')->paginate($perPage);

        return ApiResponse::success($categories, 'Categories retrieved successfully');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
// Add any other fields that need validation here
        ]);

        $category = Category::create($validatedData);

        return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
    }

    public function show($id)
    {
        $category = Category::with('locations')->findOrFail($id);

        return $category;
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
// Add any other fields that need validation here
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);

        return response()->json(['message' => 'Category updated successfully', 'data' => $category]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
