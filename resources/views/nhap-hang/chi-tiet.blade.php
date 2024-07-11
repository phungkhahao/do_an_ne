@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-2">
                <h5 style="font-size: 14px">Mã đơn nhập: <span>{{ $donHang->ma_don_nhap }}</span></h5>
                <h5 style="font-size: 14px">Ngày nhập: <span>{{ \Carbon\Carbon::parse($donHang->ngay_nhap)->format('d/m/Y')  }}</span></h5>
                <h5 style="font-size: 14px">Người tạo: <span>{{ $donHang->nhan_vien->ho_ten }}</span></h5>
                <h5 style="font-size: 14px">Tổng tiền: <span>{{ number_format($donHang->tong_tien) }}</span></h5>
                <h5 style="font-size: 14px">Ghi chú: <span>{{ $donHang->ghi_chu }}</span></h5>
            </div>
            <div class="table-responsive">
                <table id="chi-tiet" class="table table-bordered cus-talbe" >
                    <thead style="text-align: center">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        @foreach($donHang->chi_tiet as $chiTiet)
                        <tr>
                            <td>{{ $chiTiet->san_pham->ten }}</td>
                            <td>{{ $chiTiet->so_luong }}</td>
                            <td>{{ number_format($chiTiet->gia_nhap) }}</td>
                            <td>{{ number_format($chiTiet->gia_ban) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-js')
@endsection
