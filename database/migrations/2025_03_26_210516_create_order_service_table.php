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
        Schema::create('order_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('service_provider_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('price', 8, 2);
            $table->decimal('commission', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_service');
    }
};
