<?php

namespace Database\Seeders;

use App\Enums\ComplexityLevel;
use App\Models\ClothingCategory;
use App\Models\ClothingModel;
use App\Models\MeasurementType;
use App\Models\Material;
use App\Models\TailoringService;
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
            [
                'name' => 'Пошив изделия с нуля',
                'slug' => 'custom-tailoring',
                'description' => 'Полный цикл пошива по выбранной модели, меркам и референсам.',
                'pricing_mode' => 'model_based',
                'base_price' => 6000,
                'model_price_factor' => 1,
                'price_modifier' => 0,
                'requires_model' => true,
                'requires_material' => true,
                'requires_measurements' => true,
                'applies_complexity' => true,
                'applies_urgency' => true,
                'applies_quantity' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Коррекция посадки готовой вещи',
                'slug' => 'fit-alteration',
                'description' => 'Доработка готового изделия по фигуре: длина, талия, плечи, рукав, прилегание.',
                'pricing_mode' => 'alteration',
                'base_price' => 2200,
                'model_price_factor' => 0.15,
                'price_modifier' => 0,
                'requires_model' => true,
                'requires_material' => false,
                'requires_measurements' => true,
                'applies_complexity' => true,
                'applies_urgency' => true,
                'applies_quantity' => true,
                'sort_order' => 20,
            ],
            [
                'name' => 'Вечерний или праздничный образ',
                'slug' => 'occasion-look',
                'description' => 'Изделие для события с повышенным вниманием к декоративным деталям и посадке.',
                'pricing_mode' => 'model_based',
                'base_price' => 9500,
                'model_price_factor' => 1.15,
                'price_modifier' => 0,
                'requires_model' => true,
                'requires_material' => true,
                'requires_measurements' => true,
                'applies_complexity' => true,
                'applies_urgency' => true,
                'applies_quantity' => true,
                'sort_order' => 30,
            ],
            [
                'name' => 'Деловой костюм или капсула',
                'slug' => 'business-wardrobe',
                'description' => 'Костюмные изделия и согласованные комплекты для делового гардероба.',
                'pricing_mode' => 'model_based',
                'base_price' => 7000,
                'model_price_factor' => 1.1,
                'price_modifier' => 0,
                'requires_model' => true,
                'requires_material' => true,
                'requires_measurements' => true,
                'applies_complexity' => true,
                'applies_urgency' => true,
                'applies_quantity' => true,
                'sort_order' => 40,
            ],
            [
                'name' => 'Консультация по ткани и фасону',
                'slug' => 'fabric-style-consultation',
                'description' => 'Подбор ткани, силуэта и деталей перед созданием изделия.',
                'pricing_mode' => 'fixed',
                'base_price' => 2500,
                'model_price_factor' => 0,
                'price_modifier' => 0,
                'requires_model' => false,
                'requires_material' => false,
                'requires_measurements' => false,
                'applies_complexity' => false,
                'applies_urgency' => false,
                'applies_quantity' => false,
                'sort_order' => 50,
            ],
        ] as $service) {
            TailoringService::query()->updateOrCreate(['slug' => $service['slug']], [...$service, 'is_active' => true]);
        }

        foreach ([
            ['name' => 'Рост', 'slug' => 'height', 'unit' => 'см', 'help_text' => 'Полный рост без обуви.', 'is_required' => true, 'sort_order' => 10],
            ['name' => 'Обхват груди', 'slug' => 'chest', 'unit' => 'см', 'help_text' => 'По самым выступающим точкам.', 'is_required' => true, 'sort_order' => 20],
            ['name' => 'Обхват талии', 'slug' => 'waist', 'unit' => 'см', 'help_text' => 'По естественной линии талии.', 'is_required' => true, 'sort_order' => 30],
            ['name' => 'Обхват бедер', 'slug' => 'hips', 'unit' => 'см', 'help_text' => 'По самой широкой части бедер.', 'is_required' => false, 'sort_order' => 40],
            ['name' => 'Длина изделия', 'slug' => 'garment-length', 'unit' => 'см', 'help_text' => 'Желаемая длина готового изделия.', 'is_required' => false, 'sort_order' => 50],
            ['name' => 'Длина рукава', 'slug' => 'sleeve-length', 'unit' => 'см', 'help_text' => 'От плечевой точки до нужной длины.', 'is_required' => false, 'sort_order' => 60],
        ] as $measurementType) {
            MeasurementType::query()->updateOrCreate(['slug' => $measurementType['slug']], [...$measurementType, 'is_active' => true]);
        }

        $measurements = MeasurementType::query()->pluck('id', 'slug');
        $measurementRules = [
            'custom-tailoring' => ['height', 'chest', 'waist', 'hips', 'garment-length', 'sleeve-length'],
            'fit-alteration' => ['chest', 'waist', 'hips', 'garment-length', 'sleeve-length'],
            'occasion-look' => ['height', 'chest', 'waist', 'hips', 'garment-length', 'sleeve-length'],
            'business-wardrobe' => ['height', 'chest', 'waist', 'hips', 'garment-length', 'sleeve-length'],
            'fabric-style-consultation' => [],
        ];

        foreach ($measurementRules as $serviceSlug => $measurementSlugs) {
            $service = TailoringService::query()->where('slug', $serviceSlug)->firstOrFail();
            $syncData = [];

            foreach ($measurementSlugs as $index => $measurementSlug) {
                $measurementId = $measurements[$measurementSlug] ?? null;

                if (! $measurementId) {
                    continue;
                }

                $syncData[$measurementId] = [
                    'is_required' => in_array($measurementSlug, ['height', 'chest', 'waist'], true),
                    'sort_order' => ($index + 1) * 10,
                ];
            }

            $service->measurementTypes()->sync($syncData);
        }

        $modelIds = ClothingModel::query()->pluck('id', 'slug');
        $modelRules = [
            'custom-tailoring' => $modelIds->keys()->all(),
            'fit-alteration' => $modelIds->keys()->all(),
            'occasion-look' => ['classic-dress', 'evening-dress'],
            'business-wardrobe' => ['business-suit', 'mens-shirt', 'pencil-skirt', 'classic-trousers'],
            'fabric-style-consultation' => [],
        ];

        foreach ($modelRules as $serviceSlug => $modelSlugs) {
            $service = TailoringService::query()->where('slug', $serviceSlug)->firstOrFail();
            $service->clothingModels()->sync(
                collect($modelSlugs)
                    ->map(fn (string $modelSlug): ?int => $modelIds[$modelSlug] ?? null)
                    ->filter()
                    ->values()
                    ->all(),
            );
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
