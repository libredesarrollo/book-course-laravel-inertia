<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\Put;
use App\Http\Requests\Category\Store;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(2);
        return inertia('Dashboard/Category/Index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Dashboard/Category/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        Category::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return inertia('Dashboard/Category/Edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Put $request, Category $category)
    {
        $category->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
    }
}
