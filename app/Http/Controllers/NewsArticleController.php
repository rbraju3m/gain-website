<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\View\View;

class NewsArticleController extends Controller
{
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
