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
        Schema::create('clothing_model_tailoring_service', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tailoring_service_id')->constrained('tailoring_services')->cascadeOnDelete();
            $table->foreignId('clothing_model_id')->constrained('clothing_models')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['tailoring_service_id', 'clothing_model_id'], 'service_model_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_model_tailoring_service');
    }
};
