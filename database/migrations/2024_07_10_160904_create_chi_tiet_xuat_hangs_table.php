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
        Schema::create('chi_tiet_xuat_hang', function (Blueprint $table) {
            $table->id();
            $table->integer('xuat_hang_id');
            $table->integer('san_pham_id');
            $table->integer('so_luong');
            $table->integer('don_gia');
            $table->integer('thanh_tien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_xuat_hang');
    }
};
