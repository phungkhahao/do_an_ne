<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\ViTri;

class ViTriController extends Controller
{
    public function index()
    {
        $dsViTri = ViTri::all();
        return view('vi-tri.danh-sach', compact('dsViTri'));
    }

    public function create()
    {
        return view('vi-tri.them');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ma' => 'required|unique:App\Models\ViTri,ma,NULL,id,deleted_at,NULL',
                'ten' => "required",
            ],
            [
                'ma.required'       => 'Mã vị trí không được trống',
                'ten.required'      => 'Tên vị trí không được trống',
                'ma.unique'         => 'Mã vị trí đã tồn tại',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $viTri                = new ViTri();
        $viTri->ma            = $request->ma;
        $viTri->ten           = $request->ten;
        $viTri->save();

        return response()->json([
            'success'   => true,
            'message'   => "Thêm vị trí thành công",
            'redirect'  => route('vi_tri.danh_sach')

        ], 200);
    }

    public function edit($id)
    {
        $viTri = ViTri::find($id);
        return view('vi-tri.cap-nhat', compact('viTri'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ma' => "required|unique:App\Models\ViTri,ma, {$request->id},id,deleted_at,NULL",
                'ten' => "required",
            ],
            [
                'ma.required'       => 'Mã vị trí không được trống',
                'ten.required'      => 'Tên vị trí không được trống',
                'ma.unique'         => 'Mã vị trí đã tồn tại',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $viTri                = ViTri::find($request->id);
        $viTri->ma            = $request->ma;
        $viTri->ten           = $request->ten;
        $viTri->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật vị trí thành công",
            'redirect'  => route('vi_tri.danh_sach')

        ], 200);
    }
}
