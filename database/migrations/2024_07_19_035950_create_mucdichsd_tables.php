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
        // Bảng Mục đích sử dụng, phân loại chính
        Schema::create('mucdichsd.mdsd_phanloaichinh', function (Blueprint $table) {
            $table->id('malr3');
            $table->string('tenmdsdc')->nullable();
        });

        // Bảng Mục đích sử dụng, phân loại phụ
        Schema::create('mucdichsd.mdsd_phanloaiphu', function (Blueprint $table) {
            $table->id('mamdsd');
            $table->string('viettatmdsd')->nullable();
            $table->string('tenmdsdp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mucdichsd.mdsd_phanloaichinh');
        Schema::dropIfExists('mucdichsd.mdsd_phanloaiphu');
    }
};
