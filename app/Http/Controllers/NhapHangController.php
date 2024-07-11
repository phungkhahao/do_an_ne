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
        $module = "NhapHang";
        return view('nhap-hang.danh-sach', compact('dsHoaDonNhap', 'module'));
    }

    public function create()
    {
        $dsSanPham = SanPham::all();
        $module = "NhapHang";
        return view('nhap-hang.them', compact('dsSanPham', 'module'));
    }

    public function store(Request $request) {
        dd($request->all());
    }
}
