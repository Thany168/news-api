<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index(): JsonResponse
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return response()->json($articles);
    }

    // GET /api/articles/published
    public function published(): JsonResponse
    {
        return response()->json(Article::published()->get());
    }

    // GET /api/articles/{id}
    public function show(Article $article): JsonResponse
    {
        return response()->json($article);
    }

    // GET /api/articles/slug/{slug}
    public function bySlug(string $slug): JsonResponse
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return response()->json($article);
    }

    // POST /api/articles
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|unique:articles,slug',
            'excerpt'          => 'nullable|string',
            'content'          => 'nullable|string',
            'category'         => 'required|string',
            'author'           => 'required|string',
            'cover_image'      => 'nullable|string',
            'tags'             => 'nullable|array',
            'published'        => 'boolean',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $article = Article::create($validated);
        return response()->json($article, 201);
    }

    // PUT /api/articles/{id}
    public function update(Request $request, Article $article): JsonResponse
    {
        $validated = $request->validate([
            'title'            => 'sometimes|string|max:255',
            'slug'             => 'sometimes|string|unique:articles,slug,' . $article->id,
            'excerpt'          => 'nullable|string',
            'content'          => 'nullable|string',
            'category'         => 'sometimes|string',
            'author'           => 'sometimes|string',
            'cover_image'      => 'nullable|string',
            'tags'             => 'nullable|array',
            'published'        => 'boolean',
            'published_at'     => 'nullable|date',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $article->update($validated);
        return response()->json($article);
    }

    // DELETE /api/articles/{id}
    public function destroy(Article $article): JsonResponse
    {
        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}
