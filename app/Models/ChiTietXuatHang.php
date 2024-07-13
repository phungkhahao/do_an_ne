<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChiTietXuatHang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'chi_tiet_xuat_hang';

    public function san_pham() {
        return $this->belongsTo(SanPham::class);
    }
}
