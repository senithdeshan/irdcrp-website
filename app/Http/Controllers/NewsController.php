<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'content_en' => 'required|string',
            'published_date' => 'nullable|date',
            'status' => 'required|string',
        ]);

        News::create($request->all());

        return redirect()->route('admin.news.index')
            ->with('success', 'News created successfully.');
    }
    public function edit(News $news)
{
    return view('admin.news.edit', compact('news'));
}

public function update(Request $request, News $news)
{
    $request->validate([
        'title_en' => 'required|string|max:255',
        'content_en' => 'required|string',
        'published_date' => 'nullable|date',
        'status' => 'required|string',
    ]);

    $news->update($request->all());

    return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
}

public function destroy(News $news)
{
    $news->delete();

    return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
}
}