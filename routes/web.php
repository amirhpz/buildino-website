<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('home');
Route::view('/pricing', 'pricing')->name('pricing');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:3,1')->name('contact.store');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/llms.txt', [SeoController::class, 'llms'])->name('seo.llms');
