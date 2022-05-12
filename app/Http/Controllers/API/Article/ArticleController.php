<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\API\APIController;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Articles;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends APIController
{

    private $UPLOAD_PATH = 'images';

    public function index()
    {
        $articles = Articles::all();
        return $this->successResponse(
            ArticleResource::collection($articles)
        );
    }

    public function store(CreateArticleRequest $request)
    {
        $validatedInput = $request->validated();
        $filename = time() . '.' . $request->file('image')->extension();
        Storage::putFileAs(
            'public/' . $this->UPLOAD_PATH,
            $request->file('image'),
            $filename
        );

        $validatedInput['image'] = $this->UPLOAD_PATH . '/' . $filename;
        $article = Articles::create($validatedInput);

        if ($article)
            return $this->createdResponse(
                new ArticleResource($article)
            );
        return $this->errorResponse();
    }

    public function show($id)
    {
        try {
            $article = Articles::findOrFail($id);
            return $this->successResponse(new ArticleResource($article));
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data artikel tidak ditemukan.');
        }
    }

    public function update(CreateArticleRequest $request, $id)
    {
        $validatedInput = $request->validated();
        try {
            $article = Articles::findOrFail($id);
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $validatedInput['image'] = $imageName;
            $article->update($validatedInput);
            return $this->successResponse(new ArticleResource($article));
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data artikel tidak ditemukan.');
        }
    }

    public function destroy($id)
    {
        try {
            $article = Articles::findOrFail($id);
            unlink('storage/' . $article->image);
            $article->delete();
            return $this->successResponse();
        } catch (ModelNotFoundException $exception) {
            return $this->notFoundResponse('Data artikel tidak ditemukan.');
        }
    }
}
