<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ChiTietNhapHang;
use App\Models\KhoHang;
use App\Models\NhapHang;
use App\Models\SanPham;
use App\Models\ViTri;

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
        $dsSanPham  = SanPham::all();
        $dsViTri    = ViTri::all();
        $module = "NhapHang";
        return view('nhap-hang.them', compact('dsViTri', 'dsSanPham', 'module'));
    }

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'ngay_nhap' => "required",
                'vi_tri'    => "required",

            ],
            [
                'ngay_nhap.required' => 'Ngày nhập không được trống',
                'vi_tri.required'   => 'Vị trí không được trống',
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
        $nhapHang->vi_tri_id       = $request->vi_tri;
        $nhapHang->tong_tien       = $tongTien;
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
        $module     = "NhapHang";
        $dsViTri    = ViTri::all();

        return view('nhap-hang.cap-nhat', compact('dsViTri', 'donHang', 'dsSanPham', 'module'));
    }

    public function update(Request $request){
        $nhapHang = NhapHang::find($request->nhap_hang_id);

        $validator = Validator::make(
            $request->all(),
            [
                'ngay_nhap' => "required",
                'vi_tri'   => "required",

            ],
            [
                'ngay_nhap.required' => 'Ngày nhập không được trống',
                'vi_tri.required'    => 'Vị trí không được trống',

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
        $nhapHang->vi_tri_id       = $request->vi_tri;
        $nhapHang->tong_tien       = $tongTien;
        $nhapHang->save();

        foreach ($nhapHang->chi_tiet as $chiTiet) {
            ChiTietNhapHang::find($chiTiet->id)->delete();
            KhoHang::where('chi_tiet_nhap_hang_id', $chiTiet->id)->delete();
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

    public function viewKhoHang()
    {
        $dsKhoHang = KhoHang::select(['kho_hang.*', 'nhap_hang.id as idNhapHang' ])
        ->leftjoin('chi_tiet_nhap_hang', 'chi_tiet_nhap_hang.id', '=', 'kho_hang.chi_tiet_nhap_hang_id')
        ->leftjoin('nhap_hang', 'nhap_hang.id', '=', 'chi_tiet_nhap_hang.nhap_hang_id')
        ->get();
        $module = "KhoHang";
        return view('kho-hang', compact('dsKhoHang', 'module'));
    }

}
