<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use App\Models\NhapHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\SanPham;

class SanPhamController extends Controller
{
    public function index()
    {
        $dsSanPham  = SanPham::all();
        $module     = "SanPham";
        return view('san-pham.danh-sach', compact('dsSanPham', 'module'));
    }

    public function create()
    {
        $module     = "SanPham";
        $dsNhaCungCap = NhaCungCap::all();
        return view('san-pham.them', compact('dsNhaCungCap', 'module'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ma'            => 'required|unique:App\Models\SanPham,ma,NULL,id,deleted_at,NULL',
                'ten'           => "required",
                'mo_ta'         => "required",
                'nha_cung_cap'  => "required",
            ],
            [
                'ma.required'              => 'Mã sản phẩm không được trống',
                'ten.required'             => 'Tên sản phẩm không được trống',
                'ma.unique'                => 'Mã sản phẩm đã tồn tại',
                'mo_ta.required'           => 'Mô tả sản phẩm không được trống',
                'nha_cung_cap.required'    => 'Nhà cung cấp không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $sanPham                     = new SanPham();
        $sanPham->ma                 = $request->ma;
        $sanPham->ten                = $request->ten;
        $sanPham->mo_ta              = $request->mo_ta;
        $sanPham->nha_cung_cap_id    = $request->nha_cung_cap;
        $sanPham->trang_thai         = 0;
        $sanPham->save();

        return response()->json([
            'success'   => true,
            'message'   => "Thêm sản phẩm thành công",
            'redirect'  => route('san_pham.danh_sach')

        ], 200);
    }

    public function edit($id)
    {
        $module  = "SanPham";
        $sanPham    = SanPham::find($id);
        $dsNhaCungCap = NhaCungCap::all();
        return view('san-pham.cap-nhat', compact('sanPham', 'dsNhaCungCap', 'module'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ma'            => "required|unique:App\Models\SanPham,ma, {$request->id},id,deleted_at,NULL",
                'ten'           => "required",
                'mo_ta'         => "required",
                'nha_cung_cap'  => "required",
            ],
            [
                'ma.required'              => 'Mã sản phẩm không được trống',
                'ten.required'             => 'Tên sản phẩm không được trống',
                'ma.unique'                => 'Mã sản phẩm đã tồn tại',
                'mo_ta.required'           => 'Mô tả sản phẩm không được trống',
                'nha_cung_cap.required'    => 'Nhà cung cấp không được trống',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $sanPham                   = SanPham::find($request->id);
        $sanPham->ma               = $request->ma;
        $sanPham->ten              = $request->ten;
        $sanPham->mo_ta            = $request->mo_ta;
        $sanPham->nha_cung_cap_id  = $request->nha_cung_cap;
        $sanPham->trang_thai       = 0;
        $sanPham->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật sản phẩm thành công",
            'redirect'  => route('san_pham.danh_sach')

        ], 200);
    }
}
