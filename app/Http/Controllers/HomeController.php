<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Brand, Category, Product, Project, Testimonial};
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $html = Cache::remember('home', 600, fn () => view('home.index', [
            'categories' => Category::where('is_active', true)
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->orderBy('sort_order')->get(),
            'bestSellers' => Product::with(['category', 'brand'])
                ->where('is_active', true)->where('is_best_seller', true)
                ->orderBy('sort_order')->take(8)->get(),
            'brands' => Brand::where('is_active', true)->get(),
            'testimonials' => Testimonial::where('is_active', true)->where('is_featured', true)
                ->orderBy('sort_order')->take(3)->get(),
            'projects' => Project::where('is_active', true)->where('is_featured', true)
                ->orderBy('sort_order')->take(3)->get(),
        ])->render());

        return response($html);
    }
}
