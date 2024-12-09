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
        //Bảng Lô rừng
       /*  Schema::create('lamnghiep.lorung', function (Blueprint $table) {
            $table->id('tt');
            $table->bigInteger('id')->nullable();
            $table->string('matinh')->nullable();
            $table->string('mahuyen')->nullable();
            $table->string('maxa')->nullable();
            $table->string('tenxa')->nullable();
            $table->string('matieukhu')->nullable();
            $table->string('makhoanh')->nullable();
            $table->string('malo')->nullable();
            $table->bigInteger('soto')->nullable();
            $table->bigInteger('sothua')->nullable();
            $table->string('diadanh')->nullable();
            $table->double('dientich')->nullable();
            $table->integer('mangr')->nullable();
            $table->string('ldlr')->nullable();
            $table->integer('maldlr')->nullable();
            $table->string('loaicay')->nullable();
            $table->integer('namtrong')->nullable();
            $table->integer('captuoi')->nullable();
            $table->integer('nkheptan')->nullable();
            $table->integer('mangrt')->nullable();
            $table->integer('mathanhrung')->nullable();
            $table->double('mgo')->nullable();
            $table->double('mtn')->nullable();
            $table->double('mgolo')->nullable();
            $table->double('mtnlo')->nullable();
            $table->integer('malapdia')->nullable();
            $table->integer('malr3')->nullable();
            $table->string('quyuocmdsd')->nullable();
            $table->integer('mamdsd')->nullable();
            $table->integer('madoituong')->nullable();
            $table->string('churung')->nullable();
            $table->bigInteger('machurung')->nullable();
            $table->integer('matranhchap')->nullable();
            $table->integer('mattqsdd')->nullable();
            $table->integer('thoihansd')->nullable();
            $table->integer('makhoan')->nullable();
            $table->integer('mattqh')->nullable();
            $table->string('nguoiky')->nullable();
            $table->string('nguoichiutn')->nullable();
            $table->bigInteger('manguoiky')->nullable();
            $table->bigInteger('manguoichiutn')->nullable();
            $table->integer('mangsinh')->nullable();
            $table->double('kinhdo')->nullable();
            $table->double('vido')->nullable();
            $table->string('capkinhdo')->nullable();
            $table->string('capvido')->nullable();
            $table->string('malocu')->nullable();
            $table->integer('mathuadat')->nullable();
            $table->string('tentinh')->nullable();
            $table->string('tenhuyen')->nullable();
        });

        //Bảng Đối tượng
        Schema::create('lamnghiep.doituong', function (Blueprint $table) {
            $table->id('madoituong');
            $table->string('viettatdt')->nullable();
            $table->string('tendoituong')->nullable();
        });

        //Bảng Loại đất loại rừng
        Schema::create('lamnghiep.loaidatloairung', function (Blueprint $table) {
            $table->id('maldlr');
            $table->string('viettatldlr')->nullable();
            $table->string('ldlr')->nullable();
            $table->integer('truluongmin')->nullable();
            $table->integer('truluongmax')->nullable();
        });

        //Bảng Biến động diện tích rừng
        Schema::create('lamnghiep.biendong_dtrung', function (Blueprint $table) {
            $table->id('mabddtr');
            $table->integer('madienbien')->nullable();
            $table->integer('maldlr_tbd')->nullable();
            $table->string('thoigianbd')->nullable();
            $table->string('tenlomoi')->nullable();
            $table->string('malomoi')->nullable();
            $table->string('maldlr_sbd')->nullable();
            $table->double('dientichbd')->nullable();
            $table->string('loaicay')->nullable();
            $table->integer('namtrong')->nullable();
            $table->integer('malr3')->nullable();
            $table->string('ghichu')->nullable();
            $table->string('nguonvt')->nullable();
        }); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       /*  Schema::dropIfExists('lamnghiep.lorung');
        Schema::dropIfExists('lamnghiep.doituong');
        Schema::dropIfExists('lamnghiep.loaidatloairung');
        Schema::dropIfExists('lamnghiep.biendong_dtrung'); */
    }
};
