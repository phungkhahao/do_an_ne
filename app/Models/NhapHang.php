<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhapHang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'nhap_hang';
    protected $appends = ['ma_don_nhap'];
    
    protected function getMaDonNhapAttribute()
    {
        return "DN".str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }

    public function nhan_vien()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function chi_tiet()
    {
        return $this->hasMany(ChiTietNhapHang::class);
    }

    public function vi_tri()
    {
        return $this->belongsTo(ViTri::class);
    }
}
