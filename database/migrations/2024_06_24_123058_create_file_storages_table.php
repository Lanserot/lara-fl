<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_storages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('original_name');
            $table->text('name');
            $table->text('path');
            $table->text('format');
            $table->text('mime_type');
            $table->bigInteger('size');
            $table->integer('group');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('user_id');
            $table->index('group');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_storages');
    }
};
