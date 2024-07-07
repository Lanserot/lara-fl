<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->tinyText('title')->nullable(false);
            $table->mediumText('description')->nullable(false);
            $table->bigInteger('budget')->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('budget');
            $table->index('date');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
