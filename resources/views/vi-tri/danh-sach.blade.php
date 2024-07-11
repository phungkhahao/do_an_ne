@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a href="{{ route('vi_tri.create') }}" id="btn-them-moi" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                <i class="bx bxs-plus-square"></i>Thêm mới
            </a>
        </div>
        <div class="table-responsive">
            <table id="product" class="table table-bordered">
                <thead style="text-align: center">
                    <tr>
                        <th>Mã vị trí</th>
                        <th>Tên vị trí</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dsViTri as $viTri)
                    <tr>
                        <td>{{ $viTri->ma }}</td>
                        <td>{{ $viTri->ten }}</td>
                        <td>
                            <a href="{{ route('vi_tri.edit', ['id' => $viTri->id]) }}" class="btn btn-primary btn-sm">Sửa</a>
                          
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
