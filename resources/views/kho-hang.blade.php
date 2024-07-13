@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="table-responsive">
            <table id="kho-hang" class="table table-bordered cus-talbe">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Sản phẩm</th>
                        <th>Số lượng tồn</th>
                        <th>Giá nhập</th>
                        <th>Giá bán</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($dsKhoHang as $khoHang)
                    <tr>
                        <td>{{ "DX".str_pad($khoHang->idNhapHang, 8, "0", STR_PAD_LEFT) }}</td>
                        <td>{{ $khoHang->san_pham->ten }}</td>
                        <td>{{ $khoHang->so_luong }}</td>
                        <td>{{ number_format($khoHang->nhap_hang->gia_nhap) }}</td>
                        <td>{{ number_format($khoHang->nhap_hang->gia_ban) }}</td>
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
