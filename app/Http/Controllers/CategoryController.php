<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::with(['admin'])->paginate(10);
        return CategoryResource::collection($categories);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_desc' => 'nullable|string',
            'category_image' => 'nullable|image|max:2048',
            'admin_id' => 'nullable|exists:users,id',
        ]);

        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('categories', 'public');
            $validated['category_image'] = $imagePath;
        }

        // Add the admin_id to the validated data
        $validated['admin_id'] = auth()->id();

        $category = Category::create($validated);
        return new CategoryResource($category);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::findOrFail($id);
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_desc' => 'nullable|string',
            'category_image' => 'nullable|image|max:2048',
            'admin_id' => 'nullable|exists:users,id',
        ]);

        $category = Category::findOrFail($id);

        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('categories', 'public');
            $validated['category_image'] = $imagePath;
        }

        $category->update($validated);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully.'], 200);
    }
}
