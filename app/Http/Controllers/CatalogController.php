<?php

namespace App\Http\Controllers;

use App\Models\ClothingCategory;
use App\Models\ClothingModel;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = ClothingCategory::query()
            ->where('is_active', true)
            ->with(['clothingModels' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $models = ClothingModel::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return view('catalog.index', compact('categories', 'models'));
    }

    public function show(ClothingModel $clothingModel)
    {
        abort_unless($clothingModel->is_active, 404);

        return view('catalog.show', [
            'model' => $clothingModel->load('category'),
        ]);
    }
}
