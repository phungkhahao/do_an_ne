<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ChiTietNhapHang;
use App\Models\KhoHang;
use App\Models\NhapHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make(
            $request->all(),
            [
                'ngay_nhap' => "required",
                'ghi_chu'   => "required",
            ],
            [
                'ngay_nhap.required' => 'Họ tên không được trống',
                'ghi_chu.required'   => 'Ghi chú không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $tongTien = 0;

        $nhapHang                  = new NhapHang();
        $nhapHang->user_id         = Auth::user()->id;
        $nhapHang->ngay_nhap       = $request->ngay_nhap;
        $nhapHang->ghi_chu         = $request->ghi_chu;
        $nhapHang->tong_tien = $tongTien;
        $nhapHang->save();

        $dsSanPham = json_decode($request->dsSanPham);
        foreach ($dsSanPham as $sanPham) {
            $chiTietNhapHang                  = new ChiTietNhapHang();
            $chiTietNhapHang->nhap_hang_id    = $nhapHang->id;
            $chiTietNhapHang->san_pham_id     = $sanPham->san_pham;
            $chiTietNhapHang->so_luong        = $sanPham->so_luong;
            $chiTietNhapHang->gia_nhap        = $sanPham->gia_nhap;
            $chiTietNhapHang->gia_ban	      = $sanPham->gia_ban;
            $chiTietNhapHang->thanh_tien	  = $chiTietNhapHang->gia_nhap * $chiTietNhapHang->so_luong;
            $chiTietNhapHang->save();
            
            $khoHang                           = new KhoHang();
            $khoHang->chi_tiet_nhap_hang_id    = $chiTietNhapHang->id;
            $khoHang->san_pham_id              = $sanPham->san_pham;
            $khoHang->so_luong                 = $sanPham->so_luong;
            $khoHang->save();

            $tongTien += $chiTietNhapHang->thanh_tien;
        }

        $nhapHang->tong_tien = $tongTien;
        $nhapHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Nhập hàng thành công",
            'redirect'  => route('nhap_hang.danh_sach')
        ], 200);

    }

    public function detail($id)
    {
        $donHang    = NhapHang::find($id);
        $module = "NhapHang";
        return view('nhap-hang.chi-tiet', compact('donHang', 'module'));
    }

    public function edit($id)
    {
        $donHang    = NhapHang::find($id);
        $dsSanPham  = SanPham::all();
        $module = "NhapHang";
        return view('nhap-hang.cap-nhat', compact('donHang', 'dsSanPham', 'module'));
    }

    public function update(Request $request){
        $nhapHang = NhapHang::find($request->nhap_hang_id);

        $validator = Validator::make(
            $request->all(),
            [
                'ngay_nhap' => "required",
                'ghi_chu'   => "required",
            ],
            [
                'ngay_nhap.required' => 'Họ tên không được trống',
                'ghi_chu.required'   => 'Ghi chú không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $tongTien = 0;

        $nhapHang->user_id         = Auth::user()->id;
        $nhapHang->ngay_nhap       = $request->ngay_nhap;
        $nhapHang->ghi_chu         = $request->ghi_chu;
        $nhapHang->tong_tien       = $tongTien;
        $nhapHang->save();

        foreach ($nhapHang->chi_tiet as $chiTiet) {
            ChiTietNhapHang::find($chiTiet->id)->delete();
            KhoHang::where('chi_tiet_nhap_hang_id', $chiTiet)->delete();
        }

        $dsSanPham = json_decode($request->dsSanPham);
        foreach ($dsSanPham as $sanPham) {
            $chiTietNhapHang                  = new ChiTietNhapHang();
            $chiTietNhapHang->nhap_hang_id    = $nhapHang->id;
            $chiTietNhapHang->san_pham_id     = $sanPham->san_pham;
            $chiTietNhapHang->so_luong        = $sanPham->so_luong;
            $chiTietNhapHang->gia_nhap        = $sanPham->gia_nhap;
            $chiTietNhapHang->gia_ban	      = $sanPham->gia_ban;
            $chiTietNhapHang->thanh_tien	  = $chiTietNhapHang->gia_nhap * $chiTietNhapHang->so_luong;
            $chiTietNhapHang->save();
            
            $khoHang                           = new KhoHang();
            $khoHang->chi_tiet_nhap_hang_id    = $chiTietNhapHang->id;
            $khoHang->san_pham_id              = $sanPham->san_pham;
            $khoHang->so_luong                 = $sanPham->so_luong;
            $khoHang->save();

            $tongTien += $chiTietNhapHang->thanh_tien;
        }

        $nhapHang->tong_tien = $tongTien;
        $nhapHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật thành công",
            'redirect'  => route('nhap_hang.danh_sach')
        ], 200);
    }
}
