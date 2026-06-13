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
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropForeign(['clothing_model_id']);
            $table->dropForeign(['material_id']);
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->foreignId('clothing_model_id')->nullable()->change();
            $table->foreignId('material_id')->nullable()->change();
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->foreign('clothing_model_id')->references('id')->on('clothing_models')->restrictOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropForeign(['clothing_model_id']);
            $table->dropForeign(['material_id']);
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->foreignId('clothing_model_id')->nullable(false)->change();
            $table->foreignId('material_id')->nullable(false)->change();
        });

        Schema::table('orders', function (Blueprint $table): void {
            $table->foreign('clothing_model_id')->references('id')->on('clothing_models')->restrictOnDelete();
            $table->foreign('material_id')->references('id')->on('materials')->restrictOnDelete();
        });
    }
};
