<?php

namespace App\Http\Controllers;

class PortfolioIndexController extends Controller
{
    public function index()
    {
        $portfolios = request()
            ->user()
            ->portfolios()
            ->latest()
            ->paginate(10);

        return view('portfolios.index', compact('portfolios'));
    }
}
