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
        // Đặt schema 'congtac'
        $schema = 'congtac.';

        // Bảng phân loại
        Schema::create($schema.'phanloai', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->timestamps();
        });

        // Bảng trạm tuần tra
        Schema::create($schema.'tram', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->string('diachi')->unique();
            $table->string('tenxa')->unique();
            $table->string('maxa')->unique();
            $table->string('tenhuyen')->unique();
            $table->string('mahuyen')->unique();
            $table->timestamps();
        });

        // Bảng đội tuần tra
        Schema::create($schema.'doi', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->timestamps();
        });

        // Bảng phương thức di chuyển
        Schema::create($schema.'phuongthuc_dichuyen', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->timestamps();
        });

        // Bảng nhiệm vụ
        Schema::create($schema.'nhiemvu', function (Blueprint $table) {
            $table->id();
            $table->string('ten')->unique();
            $table->string('ten_vn')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Đặt schema 'congtac'
        $schema = 'congtac.';

        Schema::dropIfExists($schema.'phanloai');
        Schema::dropIfExists($schema.'tram');
        Schema::dropIfExists($schema.'doi');
        Schema::dropIfExists($schema.'phuongthuc_dichuyen');
        Schema::dropIfExists($schema.'nhiemvu');
    }
};
