<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NhapHang;
use App\Models\SanPham;
use Illuminate\Http\Request;

class NhapHangController extends Controller
{
    public function index()
    {
        $dsHoaDonNhap = NhapHang::all();
        return view('nhap-hang.danh-sach', compact('dsHoaDonNhap'));
    }

    public function create()
    {
        $dsSanPham = SanPham::all();
        return view('nhap-hang.them', compact('dsSanPham'));
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
