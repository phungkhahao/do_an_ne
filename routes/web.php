<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\NhaCungCapController;
use App\Http\Controllers\NhapHangController;
use App\Http\Controllers\ViTriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [HomeController::class, 'login'])->name('login');
    Route::post('/dang-nhap', [HomeController::class, 'doLogin'])->name('do_login');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'viewDashboard'])->name('dashboard');
    Route::get('/dang-xuat', [HomeController::class, 'dangXuat'])->name('dang_xuat');
    Route::get('/thong-tin-tai-khoan', [HomeController::class, 'thongTinTaiKhoan'])->name('thong_tin_tai_khoan');
    Route::post('/thong-tin-tai-khoan', [HomeController::class, 'capNhatTaiKhoan'])->name('cap_nhat_tai_khoan');
    Route::post('/cap-nhat-mat-khau', [HomeController::class, 'capNhatMatKhau'])->name('cap_nhat_mat_khau');

    Route::prefix('nhap-hang')->group(function () {
        Route::name('nhap_hang.')->group(function () {
            Route::get('/danh-sach', [NhapHangController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [NhapHangController::class, 'create'])->name('create');
            Route::post('/them-moi', [NhapHangController::class, 'store'])->name('store');
            Route::get('/chi-tiet/{id}', [NhapHangController::class, 'detail'])->name('detail');
            Route::get('/cap-nhat/{id}', [NhapHangController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [NhapHangController::class, 'update'])->name('update');
            Route::post('/xoa', [NhapHangController::class, 'delete'])->name('delete');

        });
    });
    Route::prefix('san-pham')->group(function () {
        Route::name('san_pham.')->group(function () {
            Route::get('/danh-sach', [SanPhamController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [SanPhamController::class, 'create'])->name('create');
            Route::post('/them-moi', [SanPhamController::class, 'store'])->name('store');
            Route::get('/cap-nhat/{id}', [SanPhamController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [SanPhamController::class, 'update'])->name('update');
            Route::post('/xoa', [SanPhamController::class, 'delete'])->name('delete');

        });
    });
    Route::prefix('khach-hang')->group(function () {
        Route::name('khach_hang.')->group(function () {
            Route::get('/danh-sach', [KhachHangController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [KhachHangController::class, 'create'])->name('create');
            Route::post('/them-moi', [KhachHangController::class, 'store'])->name('store');
            Route::get('/cap-nhat/{id}', [KhachHangController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [KhachHangController::class, 'update'])->name('update');
            Route::post('/xoa', [KhachHangController::class, 'delete'])->name('delete');

        });
    });
    Route::prefix('nguoi-dung')->group(function () {
        Route::name('nguoi_dung.')->group(function () {
            Route::get('/danh-sach', [NguoiDungController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [NguoiDungController::class, 'create'])->name('create');
            Route::post('/them-moi', [NguoiDungController::class, 'store'])->name('store');
            Route::get('/cap-nhat/{id}', [NguoiDungController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [NguoiDungController::class, 'update'])->name('update');
            Route::post('/xoa', [NguoiDungController::class, 'delete'])->name('delete');

        });
    });
    Route::prefix('nha-cung-cap')->group(function () {
        Route::name('nha_cung_cap.')->group(function () {
            Route::get('/danh-sach', [NhaCungCapController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [NhaCungCapController::class, 'create'])->name('create');
            Route::post('/them-moi', [NhaCungCapController::class, 'store'])->name('store');
            Route::get('/cap-nhat/{id}', [NhaCungCapController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [NhaCungCapController::class, 'update'])->name('update');
            Route::post('/xoa', [NhaCungCapController::class, 'delete'])->name('delete');

        });
    });
    Route::prefix('vi-tri')->group(function () {
        Route::name('vi_tri.')->group(function () {
            Route::get('/danh-sach', [ViTriController::class, 'index'])->name('danh_sach');
            Route::get('/them-moi', [ViTriController::class, 'create'])->name('create');
            Route::post('/them-moi', [ViTriController::class, 'store'])->name('store');
            Route::get('/cap-nhat/{id}', [ViTriController::class, 'edit'])->name('edit');
            Route::post('/cap-nhat', [ViTriController::class, 'update'])->name('update');
            Route::post('/xoa', [ViTriController::class, 'delete'])->name('delete');

        });
    });
});