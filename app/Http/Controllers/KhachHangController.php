<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\KhachHang;

class KhachHangController extends Controller
{
    public function index()
    {
        $dsKhachHang = KhachHang::all();
        return view('khach-hang.danh-sach', compact('dsKhachHang'));
    }

    public function create()
    {
        return view('khach-hang.them');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten'        => "required",
                'email'         => 'required|unique:App\Models\KhachHang,email,NULL,id,deleted_at,NULL',
                'so_dien_thoai' => 'required|unique:App\Models\KhachHang,so_dien_thoai,NULL,id,deleted_at,NULL',
                'dia_chi'       => "required",
            ],
            [
                'ho_ten.required'           => 'Họ tên không được trống',
                'email.required'            => 'Email không được trống',
                'email.unique'              => 'Email đã tồn tại',
                'so_dien_thoai.required'    => 'Số điện thoại không được trống',
                'so_dien_thoai.unique'      => 'Số điện thoại đã tồn tại',
                'dia_chi.required'          => 'Địa chỉ không được trống',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $khachHang                  = new KhachHang();
        $khachHang->ho_ten          = $request->ho_ten;
        $khachHang->email           = $request->email;
        $khachHang->so_dien_thoai   = $request->so_dien_thoai;
        $khachHang->dia_chi         = $request->dia_chi;
        $khachHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Thêm khách hàng thành công",
            'redirect'  => route('khach_hang.danh_sach')

        ], 200);
    }

    public function edit($id)
    {
        $khachHang = KhachHang::find($id);
        return view('khach-hang.cap-nhat', compact('khachHang'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten'        => "required",
                'email'         => "required|unique:App\Models\KhachHang,email, {$request->id},id,deleted_at,NULL",
                'so_dien_thoai' => "required|unique:App\Models\KhachHang,so_dien_thoai, {$request->id},id,deleted_at,NULL",
                'dia_chi'       => "required",
            ],
            [
                'ho_ten.required'           => 'Họ tên không được trống',
                'email.required'            => 'Email không được trống',
                'email.unique'              => 'Email đã tồn tại',
                'so_dien_thoai.required'    => 'Số điện thoại không được trống',
                'so_dien_thoai.unique'      => 'Số điện thoại đã tồn tại',
                'dia_chi.required'          => 'Địa chỉ không được trống',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $khachHang                  = KhachHang::find($request->id);
        $khachHang->ho_ten          = $request->ho_ten;
        $khachHang->email           = $request->email;
        $khachHang->so_dien_thoai   = $request->so_dien_thoai;
        $khachHang->dia_chi         = $request->dia_chi;
        $khachHang->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật khách hàng thành công",
            'redirect'  => route('khach_hang.danh_sach')

        ], 200);
    }
}
