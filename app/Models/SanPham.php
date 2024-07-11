<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPham extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'san_pham';

    public function nha_cung_cap()
    {
        return $this->belongsTo(NhaCungCap::class);
    }
}
