<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->text('title')->nullable(false);
                $table->text('description')->nullable(false);
                $table->timestamps();
                $table->index('user_id');
                $table->foreign('user_id')->references('id')->on('users');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
