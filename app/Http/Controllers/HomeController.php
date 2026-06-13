<?php

namespace App\Http\Controllers;

use App\Models\ClothingModel;
use App\Models\TailoringService;

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

        $tailoringServices = TailoringService::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('home', compact('models', 'tailoringServices'));
    }
}
