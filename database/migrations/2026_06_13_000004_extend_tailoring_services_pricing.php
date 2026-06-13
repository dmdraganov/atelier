<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tailoring_services', function (Blueprint $table): void {
            $table->string('pricing_mode')->default('model_based')->after('description');
            $table->decimal('base_price', 10, 2)->default(0)->after('pricing_mode');
            $table->decimal('model_price_factor', 5, 2)->default(1)->after('base_price');
            $table->boolean('requires_model')->default(true)->after('price_modifier');
            $table->boolean('requires_material')->default(true)->after('requires_model');
            $table->boolean('requires_measurements')->default(true)->after('requires_material');
            $table->boolean('applies_complexity')->default(true)->after('requires_measurements');
            $table->boolean('applies_urgency')->default(true)->after('applies_complexity');
            $table->boolean('applies_quantity')->default(true)->after('applies_urgency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tailoring_services', function (Blueprint $table): void {
            $table->dropColumn([
                'pricing_mode',
                'base_price',
                'model_price_factor',
                'requires_model',
                'requires_material',
                'requires_measurements',
                'applies_complexity',
                'applies_urgency',
                'applies_quantity',
            ]);
        });
    }
};
