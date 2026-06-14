<?php

namespace App\Http\Controllers;

use App\Models\ClothingCategory;
use App\Models\ClothingModel;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = ClothingCategory::query()
            ->where('is_active', true)
            ->with([
                'clothingModels' => fn($query) => $query
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->orderBy('name')
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $activeCategory = $categories->firstWhere('slug', $request->query('category'));

        $models = ClothingModel::query()
            ->where('is_active', true)
            ->when($activeCategory, fn($query) => $query->whereBelongsTo($activeCategory, 'category'))
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        return view('catalog.index', compact('categories', 'models', 'activeCategory'));
    }

    public function show(ClothingModel $clothingModel)
    {
        abort_unless($clothingModel->is_active, 404);

        return view('catalog.show', [
            'model' => $clothingModel->load('category'),
        ]);
    }
}
