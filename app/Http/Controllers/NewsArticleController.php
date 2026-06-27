<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsArticleController extends Controller
{
    public function index(Request $request): View
    {
        $categories = NewsArticle::published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->orderBy('category')
            ->distinct()
            ->pluck('category');

        $active = $request->string('category')->toString();

        $articles = NewsArticle::published()
            ->newest()
            ->with('media')
            ->when($active !== '', fn ($q) => $q->where('category', $active))
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('articles', 'categories', 'active'));
    }

    public function show(NewsArticle $article): View
    {
        abort_if(
            $article->published_at === null || $article->published_at->isFuture(),
            404
        );

        $related = NewsArticle::published()
            ->newest()
            ->where('id', '!=', $article->id)
            ->with('media')
            ->take(3)
            ->get();

        return view('news.show', compact('article', 'related'));
    }
}
