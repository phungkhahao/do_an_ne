<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class NguoiDungController extends Controller
{
    public function index()
    {
        $dsNguoiDung = User::all();
        return view('nguoi-dung.danh-sach', compact('dsNguoiDung'));
    }

    public function create()
    {
        return view('nguoi-dung.them');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:App\Models\User,username,NULL,id,deleted_at,NULL',
                'ho_ten' => "required",
                'email' => 'required|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
                'password' => "required",
                'sdt' => 'required|unique:App\Models\User,sdt,NULL,id,deleted_at,NULL',
            ],
            [
                'username.required'     => 'Username không được trống',
                'ho_ten.required'       => 'Họ tên không được trống',
                'username.unique'       => 'Username đã tồn tại',
                'email.required'        => 'Email không được trống',
                'email.unique'          => 'Email đã tồn tại',
                'password.required'     => 'Password không được trống',
                'sdt.required'          => 'Số điện thoại không được trống',
                'sdt.unique'            => 'Số điện thoại đã tồn tại',

            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $nguoiDung              = new User();
        $nguoiDung->ho_ten      = $request->ho_ten;
        $nguoiDung->username    = $request->username;
        $nguoiDung->password    = Hash::make($request->password);
        $nguoiDung->email       = $request->email;
        $nguoiDung->sdt         = $request->sdt;
        $nguoiDung->save();

        return response()->json([
            'success'   => true,
            'message'   => "Thêm người dùng thành công",
            'redirect'  => route('nguoi_dung.danh_sach')

        ], 200);
    }

    public function edit($id)
    {
        $nguoiDung = User::find($id);
        return view('nguoi-dung.cap-nhat', compact('nguoiDung'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten' => "required",
                'email' => "required|unique:App\Models\User,email, {$request->id},id,deleted_at,NULL",
                'sdt' => "required|unique:App\Models\User,sdt, {$request->id},id,deleted_at,NULL",
            ],
            [
                'ho_ten.required' => 'Họ tên không được trống',
                'email.required'  => 'Email không được trống',
                'email.unique'    => 'Email đã tồn tại',
                'sdt.required'    => 'Số điện thoại không được trống',
            ]
        );
        
        if ($validator->fails()) {
            return response()->json([
                'success'   => false,
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $nguoiDung              = User::find($request->id);
        $nguoiDung->ho_ten      = $request->ho_ten;
        $nguoiDung->email       = $request->email;
        $nguoiDung->sdt         = $request->sdt;
        $nguoiDung->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật người dùng thành công",
            'redirect'  => route('nguoi_dung.danh_sach')

        ], 200);
    }
}
