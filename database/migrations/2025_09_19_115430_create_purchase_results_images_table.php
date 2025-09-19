<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('purchase_results_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_results_id');
            $table->string('k_number');
            $table->string('image_path'); // 保存する画像のパス
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_results_images');
    }
};
