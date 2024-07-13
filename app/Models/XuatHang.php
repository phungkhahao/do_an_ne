<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class XuatHang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'xuat_hang';
    protected $appends = ['ma_don_xuat'];
    
    protected function getMaDonXuatAttribute()
    {
        return "DX".str_pad($this->id, 8, "0", STR_PAD_LEFT);
    }

    public function nhan_vien()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function chi_tiet()
    {
        return $this->hasMany(ChiTietXuatHang::class);
    }
}
