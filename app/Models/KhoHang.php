<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KhoHang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kho_hang';

    public function nhap_hang()
    {
        return $this->belongsTo(ChiTietNhapHang::class, 'chi_tiet_nhap_hang_id', 'id');
    }

    public function san_pham()
    {
        return $this->belongsTo(SanPham::class);
    }
}
