<?php

namespace Database\Seeders;

use App\Enums\ComplexityLevel;
use App\Models\ClothingCategory;
use App\Models\ClothingModel;
use App\Models\Material;
use Illuminate\Database\Seeder;

class ClothingCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Платья',
                'slug' => 'dresses',
                'description' => 'Повседневные и вечерние платья по индивидуальным меркам.',
                'sort_order' => 10,
                'models' => [
                    ['name' => 'Классическое платье', 'slug' => 'classic-dress', 'description' => 'Лаконичное платье-футляр для офиса, мероприятий и базового гардероба.', 'image_path' => 'images/catalog/classic-dress.svg', 'base_price' => 8500, 'default_complexity' => ComplexityLevel::Medium, 'estimated_days' => 10],
                    ['name' => 'Вечернее платье', 'slug' => 'evening-dress', 'description' => 'Индивидуальный крой, декоративные детали и точная посадка по фигуре.', 'image_path' => 'images/catalog/evening-dress.svg', 'base_price' => 18000, 'default_complexity' => ComplexityLevel::Complex, 'estimated_days' => 18],
                ],
            ],
            [
                'name' => 'Костюмы',
                'slug' => 'suits',
                'description' => 'Женские и мужские костюмы для работы и особых случаев.',
                'sort_order' => 20,
                'models' => [
                    ['name' => 'Деловой костюм', 'slug' => 'business-suit', 'description' => 'Пиджак и брюки или юбка с аккуратной посадкой и подкладкой.', 'image_path' => 'images/catalog/business-suit.svg', 'base_price' => 22000, 'default_complexity' => ComplexityLevel::Complex, 'estimated_days' => 20],
                ],
            ],
            [
                'name' => 'Рубашки',
                'slug' => 'shirts',
                'description' => 'Рубашки и блузы на каждый день.',
                'sort_order' => 30,
                'models' => [
                    ['name' => 'Мужская рубашка', 'slug' => 'mens-shirt', 'description' => 'Классическая рубашка с выбором воротника, манжет и посадки.', 'image_path' => 'images/catalog/mens-shirt.svg', 'base_price' => 6200, 'default_complexity' => ComplexityLevel::Simple, 'estimated_days' => 7],
                ],
            ],
            [
                'name' => 'Юбки и брюки',
                'slug' => 'skirts-trousers',
                'description' => 'Базовые изделия с точной подгонкой по фигуре.',
                'sort_order' => 40,
                'models' => [
                    ['name' => 'Юбка-карандаш', 'slug' => 'pencil-skirt', 'description' => 'Строгая юбка с комфортной посадкой и выбранной длиной.', 'image_path' => 'images/catalog/pencil-skirt.svg', 'base_price' => 5200, 'default_complexity' => ComplexityLevel::Simple, 'estimated_days' => 6],
                    ['name' => 'Классические брюки', 'slug' => 'classic-trousers', 'description' => 'Брюки с индивидуальной посадкой, карманами и выбранной шириной.', 'image_path' => 'images/catalog/classic-trousers.svg', 'base_price' => 7000, 'default_complexity' => ComplexityLevel::Medium, 'estimated_days' => 8],
                ],
            ],
            [
                'name' => 'Пальто',
                'slug' => 'coats',
                'description' => 'Сложные верхние изделия на сезон.',
                'sort_order' => 50,
                'models' => [
                    ['name' => 'Классическое пальто', 'slug' => 'classic-coat', 'description' => 'Пальто на подкладке с воротником, карманами и точной посадкой.', 'image_path' => 'images/catalog/classic-coat.svg', 'base_price' => 28000, 'default_complexity' => ComplexityLevel::Complex, 'estimated_days' => 24],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $models = $categoryData['models'];
            unset($categoryData['models']);

            $category = ClothingCategory::query()->updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData,
            );

            foreach ($models as $index => $modelData) {
                ClothingModel::query()->updateOrCreate(
                    ['slug' => $modelData['slug']],
                    [
                        ...$modelData,
                        'category_id' => $category->id,
                        'sort_order' => ($index + 1) * 10,
                        'is_active' => true,
                    ],
                );
            }
        }

        foreach ([
            ['name' => 'Хлопок', 'description' => 'Дышащая натуральная ткань для рубашек и летних изделий.', 'price_modifier' => 0],
            ['name' => 'Костюмная шерсть', 'description' => 'Плотная ткань для костюмов, брюк и юбок.', 'price_modifier' => 2500],
            ['name' => 'Шелк', 'description' => 'Деликатный материал для платьев и блуз.', 'price_modifier' => 4200],
            ['name' => 'Пальтовая ткань', 'description' => 'Теплая плотная ткань для верхней одежды.', 'price_modifier' => 6500],
            ['name' => 'Лен', 'description' => 'Фактурная ткань для летних изделий.', 'price_modifier' => 1200],
        ] as $material) {
            Material::query()->updateOrCreate(['name' => $material['name']], $material);
        }
    }
}
