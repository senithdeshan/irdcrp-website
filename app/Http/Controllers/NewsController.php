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
        $data = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_si' => 'nullable|string|max:255',
            'title_ta' => 'nullable|string|max:255',
            'content_en' => 'required|string',
            'content_si' => 'nullable|string',
            'content_ta' => 'nullable|string',
            'published_date' => 'nullable|date',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_si' => 'nullable|string|max:255',
            'title_ta' => 'nullable|string|max:255',
            'content_en' => 'required|string',
            'content_si' => 'nullable|string',
            'content_ta' => 'nullable|string',
            'published_date' => 'nullable|date',
            'status' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}
