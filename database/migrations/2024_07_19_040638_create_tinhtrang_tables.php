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
        //Bảng Tình trạng thành rừng
        Schema::create('tinhtrang.ttthanhrung', function (Blueprint $table) {
            $table->id('mathanhrung');
            $table->string('ttthanhrung')->nullable();
        });

         //Bảng Tình trạng lập địa
         Schema::create('tinhtrang.ttlapdia', function (Blueprint $table) {
            $table->id('malapdia');
            $table->string('viettatld')->nullable();
            $table->string('tengoild')->nullable();
        });

        //Bảng Tình trạng tranh chấp
        Schema::create('tinhtrang.tttranhchap', function (Blueprint $table) {
            $table->id('matranhchap');
            $table->string('tttranhchap')->nullable();
        });

         //Bảng Tình trạng quyền sừ dụng đất
         Schema::create('tinhtrang.ttquyensudungdat', function (Blueprint $table) {
            $table->id('mattqsdd');
            $table->string('ttqsdd')->nullable();
        });

         //Bảng Tình trạng khoán bảo vệ rừng
         Schema::create('tinhtrang.ttkhoanbaoverung', function (Blueprint $table) {
            $table->id('makhoan');
            $table->string('ttkhoan')->nullable();
        });

        //Bảng Tình trạng quy hoạch
        Schema::create('tinhtrang.ttquyhoach', function (Blueprint $table) {
            $table->id('mattqh');
            $table->string('ttttqh')->nullable();
        });

         //Bảng Tình trạng nguyên sinh
         Schema::create('tinhtrang.ttnguyensinh', function (Blueprint $table) {
            $table->id('mangsinh');
            $table->string('ttngsing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tinhtrang.ttthanhrung');
        Schema::dropIfExists('tinhtrang.ttlapdia');
        Schema::dropIfExists('tinhtrang.tttranhchap');
        Schema::dropIfExists('tinhtrang.ttquyensudungdat');
        Schema::dropIfExists('tinhtrang.ttkhoanbaoverung');
        Schema::dropIfExists('tinhtrang.ttquyhoach');
        Schema::dropIfExists('tinhtrang.ttnguyensinh');
    }
};
