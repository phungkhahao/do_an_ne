<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapHang extends Model
{
    use HasFactory;
    protected $table = 'nhap_hang';

    public function nhan_vien()
    {
        return $this->belongsTo(User::class);
    }
}
