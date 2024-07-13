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
            <table id="nhap-hang" class="table table-bordered cus-talbe">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã hóa đơn</th>
                        <th>Ngày nhập</th>
                        <th>Nhân viên nhập</th>
                        <th>Vị trí</th>
                        <th>Tổng tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($dsHoaDonNhap as $hoaDonNhap)
                    <tr>
                        <td>{{ $hoaDonNhap->ma_don_nhap }}</td>
                        <td>{{ \Carbon\Carbon::parse($hoaDonNhap->ngay_nhap)->format('d/m/Y') }}</td>
                        <td>{{ $hoaDonNhap->nhan_vien->ho_ten }}</td>
                        <td>{{ $hoaDonNhap->vi_tri->ten }}</td>
                        <td>{{ number_format($hoaDonNhap->tong_tien) }}</td>
                        <td>
                            <a href="{{ route('nhap_hang.detail', ['id' => $hoaDonNhap->id]) }}" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg></a>
                            <a href="{{ route('nhap_hang.edit', ['id' => $hoaDonNhap->id]) }}" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path><path d="M13.5 6.5l4 4"></path></svg></a>
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
