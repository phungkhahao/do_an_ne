@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('nguoi_dung.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                <i class="bx bxs-plus-square"></i>Thêm mới
            </a>
        </div>
        <div class="table-responsive">
            <table id="product" class="table table-bordered">
                <thead style="text-align: center">
                    <tr>
                        <th>Họ tên</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsNguoiDung as $nguoiDung)
                    <tr>
                        <td>{{ $nguoiDung->ho_ten }}</td>
                        <td>{{ $nguoiDung->username }}</td>
                        <td>{{ $nguoiDung->email }}</td>
                        <td>{{ $nguoiDung->sdt }}</td>
                        <td>
                            <a href="{{ route('nguoi_dung.edit', ['id' => $nguoiDung->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
                          
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
