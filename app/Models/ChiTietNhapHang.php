<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChiTietNhapHang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chi_tiet_nhap_hang';

    public function san_pham() {
        return $this->belongsTo(SanPham::class);
    }

    public function nhap_hang()
    {
        return $this->belongsTo(NhapHang::class);
    }
}
