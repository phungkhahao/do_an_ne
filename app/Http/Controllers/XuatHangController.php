<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\ChiTietNhapHang;
use App\Models\ChiTietXuatHang;
use App\Models\KhoHang;
use App\Models\NhapHang;
use App\Models\XuatHang;
use App\Models\SanPham;
use App\Models\KhachHang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class XuatHangController extends Controller
{
    public function index()
    {
        $dsHoaDonXuat = XuatHang::all();
        $module = "XuatHang";
        return view('xuat-hang.danh-sach', compact('dsHoaDonXuat', 'module'));
    }

    public function create()
    {
        $dsKhoHang = KhoHang::select(['kho_hang.*', 'nhap_hang.id as idNhapHang' ])
        ->leftjoin('chi_tiet_nhap_hang', 'chi_tiet_nhap_hang.id', '=', 'kho_hang.chi_tiet_nhap_hang_id')
        ->leftjoin('nhap_hang', 'nhap_hang.id', '=', 'chi_tiet_nhap_hang.nhap_hang_id')
        ->get();

        $dsKhachHang = KhachHang::all();
        $module = "XuatHang";
        return view('xuat-hang.them', compact('dsKhoHang', 'module', 'dsKhachHang'));
    }

    public function store(Request $request) {
        
        $validator = Validator::make(
            $request->all(),
            [
                'ngay_xuat'     => "required",
                'khach_hang_id' => "required",
            ],
            [
                'ngay_xuat.required'        => 'Ngày xuất không được trống',
                'khach_hang_id.required'    => 'Khách hàng không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $dsKhoHang = json_decode($request->dsKhoHang);

        foreach ($dsKhoHang as $khoHang) {
            $duLieukhoHang  = KhoHang::find($khoHang->id);
            $sanPham        = SanPham::find($duLieukhoHang->san_pham_id);

            if($khoHang->so_luong > $duLieukhoHang->so_luong) {
                return response()->json([
                    'success'   => false,
                    'message' => $sanPham->ten . " không đủ số lượng",
                ], 200);
            }

        }

        $tongTien = 0;

        $xuatHang                  = new XuatHang();
        $xuatHang->user_id         = Auth::user()->id;
        $xuatHang->khach_hang_id   = $request->khach_hang_id;
        $xuatHang->ngay_xuat       = $request->ngay_xuat;
        $xuatHang->tong_tien = $tongTien;
        $xuatHang->save();

        foreach ($dsKhoHang as $khoHang) {

            $duLieukhoHang  = KhoHang::find($khoHang->id);
            $sanPham        = SanPham::find($duLieukhoHang->san_pham_id);

            $chiTietXuatHang                  = new ChiTietXuatHang();
            $chiTietXuatHang->xuat_hang_id    = $xuatHang->id;
            $chiTietXuatHang->san_pham_id     = $sanPham->id;
            $chiTietXuatHang->so_luong        = $khoHang->so_luong;
            $chiTietXuatHang->don_gia	      = $khoHang->don_gia;
            $chiTietXuatHang->kho_hang_id	      = $duLieukhoHang->id;
            $chiTietXuatHang->thanh_tien	  = $chiTietXuatHang->don_gia * $chiTietXuatHang->so_luong;
            $chiTietXuatHang->save();
            
            $duLieukhoHang->so_luong          -= $khoHang->so_luong;
            $duLieukhoHang->save();

            $tongTien += $chiTietXuatHang->thanh_tien;
        }

        $xuatHang->tong_tien = $tongTien;
        $xuatHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Xuất hàng thành công",
            'redirect'  => route('xuat_hang.danh_sach')
        ], 200);
    }

    public function detail($id)
    {
        $donHang    = XuatHang::find($id);
        $module = "XuatHang";
        return view('xuat-hang.chi-tiet', compact('donHang', 'module'));
    }

    public function edit($id)
    {
        $donHang    = XuatHang::find($id);
        $dsKhoHang = KhoHang::select(['kho_hang.*', 'nhap_hang.id as idNhapHang' ])
        ->leftjoin('chi_tiet_nhap_hang', 'chi_tiet_nhap_hang.id', '=', 'kho_hang.chi_tiet_nhap_hang_id')
        ->leftjoin('nhap_hang', 'nhap_hang.id', '=', 'chi_tiet_nhap_hang.nhap_hang_id')
        ->get();
        $dsKhachHang = KhachHang::all();
        $module = "NhapHang";
        return view('xuat-hang.cap-nhat', compact('donHang', 'dsKhoHang', 'module', 'dsKhachHang'));
    }

    public function update(Request $request){
        $xuatHang = XuatHang::find($request->xuat_hang_id);

        $validator = Validator::make(
            $request->all(),
            [
                'ngay_xuat'     => "required",
                'khach_hang_id' => "required",
            ],
            [
                'ngay_xuat.required'        => 'Ngày xuất không được trống',
                'khach_hang_id.required'    => 'Khách hàng không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $dsKhoHang = json_decode($request->dsKhoHang);

        foreach ($dsKhoHang as $khoHang) {
            $duLieukhoHang  = KhoHang::find($khoHang->id);
            $sanPham        = SanPham::find($duLieukhoHang->san_pham_id);
            foreach ($xuatHang->chi_tiet as $chiTiet) {
                if($chiTiet->kho_hang_id == $khoHang->id)
                {
                    $chiTietXuatHang = ChiTietXuatHang::find($chiTiet->id);
                    if($khoHang->so_luong > $duLieukhoHang->so_luong + $chiTietXuatHang->so_luong) {
                        return response()->json([
                            'success'   => false,
                            'message' => $sanPham->ten . " không đủ số lượng",
                        ], 200);
                    }
                }
            }
        }
        
        $tongTien = 0;

        $xuatHang->user_id         = Auth::user()->id;
        $xuatHang->khach_hang_id   = $request->khach_hang_id;
        $xuatHang->ngay_xuat       = $request->ngay_xuat;
        $xuatHang->tong_tien = $tongTien;
        $xuatHang->save();

        foreach ($xuatHang->chi_tiet as $chiTiet) {
            $khoHang = KhoHang::find($chiTiet->kho_hang_id);
            $khoHang->so_luong += $chiTiet->so_luong;
            $khoHang->save();
            ChiTietXuatHang::find($chiTiet->id)->delete();
        }

        foreach ($dsKhoHang as $khoHang) {

            $duLieukhoHang  = KhoHang::find($khoHang->id);
            $sanPham        = SanPham::find($duLieukhoHang->san_pham_id);

            $chiTietXuatHang                  = new ChiTietXuatHang();
            $chiTietXuatHang->xuat_hang_id    = $xuatHang->id;
            $chiTietXuatHang->san_pham_id     = $sanPham->id;
            $chiTietXuatHang->so_luong        = $khoHang->so_luong;
            $chiTietXuatHang->don_gia	      = $khoHang->don_gia;
            $chiTietXuatHang->kho_hang_id	  = $duLieukhoHang->id;
            $chiTietXuatHang->thanh_tien	  = $chiTietXuatHang->don_gia * $chiTietXuatHang->so_luong;
            $chiTietXuatHang->save();
            
            $duLieukhoHang->so_luong          -= $khoHang->so_luong;
            $duLieukhoHang->save();

            $tongTien += $chiTietXuatHang->thanh_tien;
        }

        $xuatHang->tong_tien = $tongTien;
        $xuatHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật thành công",
            'redirect'  => route('xuat_hang.danh_sach')
        ], 200);
    }
}
