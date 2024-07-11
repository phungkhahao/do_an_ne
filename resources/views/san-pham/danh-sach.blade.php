@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('san_pham.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                <i class="bx bxs-plus-square"></i>Thêm mới
            </a>
        </div>
        <div class="table-responsive">
            <table id="product" class="table table-bordered">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Nhà cung cấp</th>
                        <th>Trạng thái</th>
                        <th>Mô tả</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsSanPham as $sanPham)
                    <tr>
                        <td>{{ $sanPham->ma }}</td>
                        <td>{{ $sanPham->ten }}</td>
                        <td>{{ $sanPham->nha_cung_cap->ho_ten }}</td>
                        <td>{{ $sanPham->trang_thai }}</td>
                        <td>{{ $sanPham->mo_ta }}</td>
                        <td>
                            <a href="{{ route('san_pham.edit', ['id' => $sanPham->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
                          
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
