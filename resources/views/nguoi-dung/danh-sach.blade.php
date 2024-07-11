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
            <table id="nguoi-dung" class="table table-bordered cus-talbe">
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
                        <td style="justify-content: center; display: flex">
                            <a href="{{ route('nguoi_dung.edit', ['id' => $nguoiDung->id]) }}" class="btn btn-success btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"></path><path d="M13.5 6.5l4 4"></path></svg></a>
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
