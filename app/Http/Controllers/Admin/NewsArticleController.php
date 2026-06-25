<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsArticle\NewsArticleRequest;
use App\Models\NewsArticle;

class NewsArticleController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        $article = new NewsArticle(['published_at' => now()]);
        return view('admin.news.create', compact('article'));
    }

    public function store(NewsArticleRequest $request)
    {
        $data = $request->safe()->except(['image', 'remove_image']);
        $data['slug'] = NewsArticle::generateSlug($data['title']);

        $article = NewsArticle::create($data);
        $this->syncImage($article, $request);

        return redirect()->route('admin.news.index')
            ->with('status', "Article “{$article->title}” created.");
    }

    public function edit(NewsArticle $news)
    {
        return view('admin.news.edit', ['article' => $news]);
    }

    public function update(NewsArticleRequest $request, NewsArticle $news)
    {
        $data = $request->safe()->except(['image', 'remove_image']);

        // Only regenerate the slug if the title actually changed.
        if (isset($data['title']) && $data['title'] !== $news->title) {
            $data['slug'] = NewsArticle::generateSlug($data['title'], $news->id);
        }

        $news->update($data);
        $this->syncImage($news, $request);

        return redirect()->route('admin.news.index')
            ->with('status', "Article “{$news->title}” saved.");
    }

    public function destroy(NewsArticle $news)
    {
        $title = $news->title;
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('status', "Article “{$title}” deleted.");
    }

    private function syncImage(NewsArticle $article, NewsArticleRequest $request): void
    {
        if ($request->boolean('remove_image')) {
            $article->clearMediaCollection('image');
        }
        if ($request->hasFile('image')) {
            $article->clearMediaCollection('image');
            $article->addMediaFromRequest('image')->toMediaCollection('image');
        }
    }
}
