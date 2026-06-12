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
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('master_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('clothing_model_id')->constrained('clothing_models')->restrictOnDelete();
            $table->foreignId('material_id')->constrained('materials')->restrictOnDelete();
            $table->string('status')->default('new')->index();
            $table->unsignedInteger('quantity')->default(1);
            $table->string('complexity')->default('medium');
            $table->string('urgency')->default('standard');
            $table->jsonb('measurements')->nullable();
            $table->jsonb('parameters')->nullable();
            $table->text('customer_comment')->nullable();
            $table->text('admin_comment')->nullable();
            $table->decimal('preliminary_price', 10, 2);
            $table->decimal('final_price', 10, 2)->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
