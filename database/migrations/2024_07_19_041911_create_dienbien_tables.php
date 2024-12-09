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
        //Bảng Loại diễn biến rừng
        Schema::create('dienbien.dienbien_loai', function (Blueprint $table) {
            $table->id('madienbien');
            $table->string('tengoidb')->nullable();
            $table->integer('manhomdb')->nullable();
        });

        //Bảng Nhóm diễn biến
        Schema::create('dienbien.dienbien_nhom', function (Blueprint $table) {
            $table->id('manhomdb');
            $table->integer('mahuongdb')->nullable();
            $table->string('tengoindb')->nullable();
        });

        //Bảng Hướng diễn biến
        Schema::create('dienbien.dienbien_huong', function (Blueprint $table) {
            $table->id('mahuongdb');
            $table->string('tengoihdb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dienbien.dienbien_loai');
        Schema::dropIfExists('dienbien.dienbien_nhom');
        Schema::dropIfExists('dienbien.dienbien_huong');
    }
};
