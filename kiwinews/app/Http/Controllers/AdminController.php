<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Kunin ang mga kategorya na naka-order base sa sort_order
        $categories = Category::orderBy('sort_order', 'asc')->get();
        $categoryCounts = [];

        foreach ($categories as $cat) {
            $categoryCounts[$cat->name] = Article::where('category', $cat->name)->count();
        }

        // Kunin ang huling 7 araw para sa Daily Graph kasama ang totoong views
        $dailyLabels = [];
        $dailyValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('D'); // Halimbawa: Mon, Tue, Wed
            
            $viewsSum = Article::whereDate('updated_at', $date->toDateString())->sum('daily_views');
            $dailyValues[] = $viewsSum ?: 0;
        }

        $topWeekly = Article::orderByDesc('weekly_views')->take(4)->pluck('weekly_views')->reverse()->implode(',');
        $topMonthly = Article::orderByDesc('monthly_views')->take(12)->pluck('monthly_views')->reverse()->implode(',');
        $topYearly = Article::orderByDesc('yearly_views')->take(4)->pluck('yearly_views')->reverse()->implode(',');

        return view('admin.dashboard', [
            'totalArticles' => Article::count(),
            'categories' => $categories,
            'categoryCounts' => $categoryCounts, 
            'articles' => Article::latest()->paginate(10),
            'dailyLabels' => json_encode($dailyLabels),
            'dailyValues' => implode(',', $dailyValues),
            'topWeekly' => $topWeekly ?: '0,0,0,0',
            'topMonthly' => $topMonthly ?: '0,0,0,0,0,0,0,0,0,0,0,0',
            'topYearly' => $topYearly ?: '0,0,0,0',
        ]);
    }

    public function storeArticle(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov,ogg|max:20480',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('articles', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $validated['video_url'] = asset('storage/' . $videoPath);
        }

        $validated['image_url'] = $imagePaths[0] ?? null;
        $validated['images'] = $imagePaths ?: null;
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['published_at'] = now();
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_breaking'] = $request->has('is_breaking');

        Article::create($validated);

        return back()->with('success', 'Matagumpay na nai-post ang balita kasama ang mga larawan!');
    }

    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov,ogg|max:20480',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('articles', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('videos', 'public');
            $validated['video_url'] = asset('storage/' . $videoPath);
        }

        $existingImages = is_array($article->images) ? $article->images : [];
        $validated['images'] = array_values(array_unique(array_merge($existingImages, $imagePaths)));

        if (empty($validated['image_url'])) {
            $validated['image_url'] = $article->image_url ?: ($validated['images'][0] ?? null);
        }

        if (!isset($validated['video_url'])) {
            $validated['video_url'] = $article->video_url;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_breaking'] = $request->has('is_breaking');

        $article->update($validated);

        return back()->with('success', 'Matagumpay na na-update ang balita!');
    }

    public function destroyArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return back()->with('success', 'Matagumpay na na-delete ang balita!');
    }

    // MAGDAGDAG NG KATEGORYA MAY KASAMANG SORT ORDER
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'sort_order' => 'nullable|integer',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'Matagumpay na naidagdag ang bagong kategorya!');
    }

    // I-UPDATE ANG KATEGORYA AT SORT ORDER
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'sort_order' => 'required|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order,
        ]);

        return back()->with('success', 'Matagumpay na na-update ang kategorya!');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Matagumpay na na-delete ang kategorya!');
    }

    // <--- Idinagdag para i-save ang bagong pagkakasunod-sunod galing sa Drag & Drop
    public function reorderCategories(Request $request)
    {
        if ($request->has('order')) {
            foreach ($request->order as $item) {
                Category::where('id', $item['id'])->update([
                    'sort_order' => $item['sort_order']
                ]);
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    public function index()
    {
        $featuredStoriesCount = Article::where('is_featured', true)->count();
        
        return view('home', [
            'featuredStory' => Article::where('is_featured', true)->latest()->first(),
            'featuredStories' => Article::where('is_featured', true)->latest()->take(5)->get(),
            'hasMoreFeatured' => $featuredStoriesCount > 5,
            'breakingNews' => Article::where('is_breaking', true)->latest()->get(),
            'articles' => Article::latest()->paginate(8),
        ]);
    }
}