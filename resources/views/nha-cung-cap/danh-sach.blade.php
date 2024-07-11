@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('nha_cung_cap.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
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
                    @foreach($dsNhaCungCap as $nhaCungCap)
                    <tr>
                        <td>{{ $nhaCungCap->ho_ten }}</td>
                        <td>{{ $nhaCungCap->email }}</td>
                        <td>{{ $nhaCungCap->so_dien_thoai }}</td>
                        <td>{{ $nhaCungCap->dia_chi }}</td>
                        <td>
                            <a href="{{ route('nha_cung_cap.edit', ['id' => $nhaCungCap->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
                          
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
