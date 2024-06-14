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
        Schema::create('order_to_category', function (Blueprint $table) {
                $table->id();
                $table->integer('order_id')->nullable(false);
                $table->integer('category_id')->nullable(false);
                $table->timestamps();
                $table->index('order_id');
                $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_to_category');
    }
};
