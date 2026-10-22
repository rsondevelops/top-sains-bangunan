<?php

use App\Http\Controllers\{ArticleController, LeadController, PageController, ProjectController, RecommendationController, SolutionController};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

use App\Http\Controllers\Admin\{
    ArticleController as AdminArticleController,
    BrandController as AdminBrandController,
    CategoryController as AdminCategoryController,
    LeadController as AdminLeadController,
    ProjectController as AdminProjectController,
    SettingController,
    TestimonialController as AdminTestimonialController
};

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{category}', [ProductController::class, 'category'])->name('products.category');
Route::get('/produk/{category}/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/brand/{slug}', [ProductController::class, 'brand'])->name('brands.show');


Route::get('/bantu-memilih', [RecommendationController::class, 'index']);

Route::get('/solusi/{segment}', [SolutionController::class, 'show'])
    ->whereIn('segment', ['proyek', 'kontraktor', 'developer', 'hotel-villa']);
Route::post('/permintaan-penawaran', [LeadController::class, 'quotation'])->middleware('throttle:6,1');

Route::get('/project', [ProjectController::class, 'index']);
Route::get('/project/{slug}', [ProjectController::class, 'show']);

Route::get('/artikel', [ArticleController::class, 'index']);
Route::get('/artikel/{slug}', [ArticleController::class, 'show']);

Route::get('/after-sales', [PageController::class, 'afterSales']);
Route::get('/tentang-kami', [PageController::class, 'about']);
Route::get('/kontak', [PageController::class, 'contact']);

Route::get('/{slug}', [PageController::class, 'local'])
    ->whereIn('slug', ['sanitary-bogor', 'toto-bogor', 'sanitary-jakarta', 'sanitary-bsd']);


Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->prefix('dashboard')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');
    Route::resource('brands', AdminBrandController::class)->except('show');
    Route::resource('testimonials', AdminTestimonialController::class)->except('show');
    Route::resource('projects', AdminProjectController::class)->except('show');
    Route::resource('articles', AdminArticleController::class)->except('show');
    Route::resource('leads', AdminLeadController::class)->only(['index', 'update', 'destroy']);
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
