<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

final class LandingPageController extends Controller
{
    public function __invoke(): View
    {
        return view('home');
    }
}
