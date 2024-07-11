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
        Schema::create('kho_hang', function (Blueprint $table) {
            $table->id();
            $table->integer('chi_tiet_nhap_hang_id');
            $table->integer('san_pham_id');
            $table->integer('so_luong');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kho_hang');
    }
};
