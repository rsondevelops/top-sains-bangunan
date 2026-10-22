<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Article, Lead, Product, Project, Testimonial};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'Produk'      => Product::count(),
                'Best seller' => Product::where('is_best_seller', true)->count(),
                'Testimonial' => Testimonial::count(),
                'Artikel'     => Article::count(),
                'Project'     => Project::count(),
            ],
            'leads' => Lead::latest()->take(5)->get(),
        ]);
    }
}