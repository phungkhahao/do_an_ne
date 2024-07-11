@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('khach_hang.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                <i class="bx bxs-plus-square"></i>Thêm mới
            </a>
        </div>
        <div class="table-responsive">
            <table id="product" class="table table-bordered">
                <thead style="text-align: center">
                    <tr>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsKhachHang as $khachHang)
                    <tr>
                        <td>{{ $khachHang->ho_ten }}</td>
                        <td>{{ $khachHang->email }}</td>
                        <td>{{ $khachHang->so_dien_thoai }}</td>
                        <td>{{ $khachHang->dia_chi }}</td>
                        <td>
                            <a href="{{ route('khach_hang.edit', ['id' => $khachHang->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
                          
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection
@section('page-js')

@endsection
