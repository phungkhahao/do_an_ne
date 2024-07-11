@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('nhap_hang.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                <i class="bx bxs-plus-square"></i>Thêm mới
            </a>
        </div>
        <div class="table-responsive">
            <table id="product" class="table table-bordered">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày nhập</th>
                        <th>Nhân viên nhập</th>
                        <th>Tổng tiền</th>
                        <th>Ghi chú</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsHoaDonNhap as $hoaDonNhap)
                    <tr>
                        <td>{{ $hoaDonNhap->id }}</td>
                        <td>{{ $hoaDonNhap->ngay_nhap }}</td>
                        <td>{{ $hoaDonNhap->nhan_vien->ho_ten }}</td>
                        <td>{{ $hoaDonNhap->tong_tien }}</td>
                        <td>{{ $hoaDonNhap->ghi_chu }}</td>
                        <td>
                            <a href="{{ route('nhap-hang.edit', ['id' => $hoaDonNhap->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
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
