<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\NhaCungCap;

class NhaCungCapController extends Controller
{
    public function index()
    {
        $dsNhaCungCap   = NhaCungCap::all();
        $module         = "NhaCungCap";
        return view('nha-cung-cap.danh-sach', compact('dsNhaCungCap', 'module'));
    }

    public function create()
    {
        $module     = "NhaCungCap";
        return view('nha-cung-cap.them', compact('module'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten'        => "required",
                'email'         => 'required|unique:App\Models\NhaCungCap,email,NULL,id,deleted_at,NULL',
                'so_dien_thoai' => 'required|unique:App\Models\NhaCungCap,so_dien_thoai,NULL,id,deleted_at,NULL',
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

        $nhaCungCap                  = new NhaCungCap();
        $nhaCungCap->ho_ten          = $request->ho_ten;
        $nhaCungCap->email           = $request->email;
        $nhaCungCap->so_dien_thoai   = $request->so_dien_thoai;
        $nhaCungCap->dia_chi         = $request->dia_chi;
        $nhaCungCap->save();

        return response()->json([
            'success'   => true,
            'message'   => "Thêm nhà cung cấp thành công",
            'redirect'  => route('nha_cung_cap.danh_sach')

        ], 200);
    }

    public function edit($id)
    {
        $module     = "NhaCungCap";
        $nhaCungCap = NhaCungCap::find($id);
        return view('nha-cung-cap.cap-nhat', compact('nhaCungCap', 'module'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten'        => "required",
                'email'         => "required|unique:App\Models\NhaCungCap,email, {$request->id},id,deleted_at,NULL",
                'so_dien_thoai' => "required|unique:App\Models\NhaCungCap,so_dien_thoai, {$request->id},id,deleted_at,NULL",
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

        $nhaCungCap                  = NhaCungCap::find($request->id);
        $nhaCungCap->ho_ten          = $request->ho_ten;
        $nhaCungCap->email           = $request->email;
        $nhaCungCap->so_dien_thoai   = $request->so_dien_thoai;
        $nhaCungCap->dia_chi         = $request->dia_chi;
        $nhaCungCap->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật nhà cung cấp thành công",
            'redirect'  => route('nha_cung_cap.danh_sach')

        ], 200);
    }
}
