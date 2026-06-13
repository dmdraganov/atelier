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
        Schema::create('measurement_type_tailoring_service', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tailoring_service_id')->constrained('tailoring_services')->cascadeOnDelete();
            $table->foreignId('measurement_type_id')->constrained('measurement_types')->cascadeOnDelete();
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['tailoring_service_id', 'measurement_type_id'], 'service_measurement_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurement_type_tailoring_service');
    }
};
