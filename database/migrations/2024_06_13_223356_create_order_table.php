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
            $table->integer('user_id')->nullable(false);
            $table->text('title')->nullable(false);
            $table->text('description')->nullable(false);
            $table->timestamps();
            $table->index(['user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
