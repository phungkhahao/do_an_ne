<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\NhapHang;
use App\Models\XuatHang;
use App\Models\NhaCungCap;
use App\Models\KhachHang;

class HomeController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'success'   => true,
                'message'   => "Đăng nhập thành công",
                'redirect'  => route('dashboard')

            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Đăng nhập thất bại",
        ], 200);    
    }

    public function viewDashboard()
    {
        $soLuongKhachHang   = KhachHang::count();
        $soLuongNhaCungCap  = NhaCungCap::count();
        $soLuongXuatHang    = XuatHang::count();
        $soLuongNhapHang    = NhapHang::count();

        $dsNhapHang = Nhaphang::orderBy('created_at', 'desc')->take(5)->get();
        $dsXuatHang = XuatHang::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('dsNhapHang', 'dsXuatHang', 'soLuongKhachHang', 'soLuongNhaCungCap', 'soLuongXuatHang', 'soLuongNhapHang'));
    }

    public function thongTinTaiKhoan()
    {
        return view('thong-tin-tai-khoan.index');
    }

    public function capNhatTaiKhoan(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make(
            $request->all(),
            [
                'ho_ten' => "required",
                'email' => "required|unique:App\Models\User,email, {$user->id},id,deleted_at,NULL",
                'sdt' => "required|unique:App\Models\User,sdt, {$user->id},id,deleted_at,NULL",
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

        $user->ho_ten      = $request->ho_ten;
        $user->email       = $request->email;
        $user->sdt         = $request->sdt;
        $user->save();

        return response()->json([
            'success'   => true,
            'message'   => "Cập nhật tài khoản thành công",
        ], 200);
    }

    public function capNhatMatKhau(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required',
                'new_password' => 'required',
                'enter_new_pass' => 'required',
            ],
            [
                'password.required' => 'Chưa nhập mật khẩu cũ',
                'new_password.required' => 'Chưa nhập mật khẩu mới',
                'enter_new_pass.required' => 'Chưa nhập lại mật khẩu mới',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }
        $user = User::find(auth()->user()->id);
        if ($user == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy nhân viên này',
            ], 200);
        }
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu sai! Hãy nhập lại',
            ], 200);
        } elseif ($request->new_password != $request->enter_new_pass) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu không trùng khớp! Hãy nhập lại',
            ], 200);
        }
        if (strlen($request->new_password) < 6) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nhập mật khẩu mới ít nhất 6 kí tự',
            ], 200);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật mật khẩu thành công',
        ], 200);
    }

    public function dangXuat()
    {
        Auth::logout();
        return view('login');
    }
}
