<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('cat');
        $search = $request->query('q');

        $query = Article::published();

        if ($category) {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderByDesc('created_at')->get();
        $featured = $articles->where('featured', true)->values();
        $regular = $articles->where('featured', false)->values();
        $categories = Article::published()->distinct()->pluck('category')->sort()->values();

        return view('public.index', [
            'featured' => $featured,
            'regular' => $regular,
            'categories' => $categories,
            'selectedCategory' => $category,
            'search' => $search,
        ]);
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        if ($article->status !== 'published') {
            abort(404);
        }

        $article->incrementViews();

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->limit(3)
            ->get();

        return view('public.show', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
