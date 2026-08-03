<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Kung may piniling category, salain iyon. Kung "Mga Balita" o walang pinili, halo-halo (lahat) ang lalabas.
        if ($request->has('category') && $request->category != '' && $request->category != 'Mga Balita') {
            $cat = $request->category;
            if (strtolower($cat) == 'agriculture' || strtolower($cat) == 'agrikultura') {
                $query->whereIn('category', ['Agriculture', 'Agrikultura']);
            } else {
                $query->where('category', $cat);
            }
        }

        // Salain batay sa search keyword kung may in-type
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        return view('home', [
            // Ang Featured at Top Stories ay laging nakabase sa pinakabago (latest date/time) para sa homepage
            'featuredStory' => Article::where('is_featured', true)->latest()->first() ?? Article::latest()->first(),
            'topStories' => Article::where('is_top_story', true)->latest()->take(5)->get()->count() ? Article::where('is_top_story', true)->latest()->take(5)->get() : Article::latest()->take(5)->get(),
            'breakingNews' => Article::where('is_breaking', true)->latest()->get()->count() ? Article::where('is_breaking', true)->latest()->get() : Article::latest()->take(5)->get(),
            
            // Ang mga balita sa ibaba ay naka-ayos nang sunod-sunod batay sa pinakabagong petsa at oras (latest)
            'articles' => $query->latest()->paginate(8),
        ]);
    }
}