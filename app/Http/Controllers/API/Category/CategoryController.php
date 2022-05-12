<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends APIController
{

    public function index()
    {
        $categories = Category::all();
        return $this->successResponse(
            CategoryResource::collection($categories)
        );
    }

    public function store(CreateCategoryRequest $request)
    {
        $validatedInput = $request->validated();
        $category = Category::create($validatedInput);
        if ($category)
            return $this->createdResponse(
                new CategoryResource($category)
            );
        return $this->errorResponse();
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->successResponse(new CategoryResource($category));
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data ketegory tidak ditemukan.');
        }
    }

    public function update(CreateCategoryRequest $request, $id)
    {
        $validatedInput = $request->validated();
        try {
            $category = Category::findOrFail($id);
            $category->update($validatedInput);
            return $this->successResponse(new CategoryResource($category));
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data ketegory tidak ditemukan.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return $this->successResponse();
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data ketegory tidak ditemukan.');
        }
    }
}
