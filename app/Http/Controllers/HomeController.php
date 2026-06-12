<?php

namespace App\Http\Controllers;

use App\Models\ClothingModel;

class HomeController extends Controller
{
    public function __invoke()
    {
        $models = ClothingModel::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('home', compact('models'));
    }
}
