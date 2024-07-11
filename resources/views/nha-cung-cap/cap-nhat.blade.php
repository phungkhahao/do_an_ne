@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-cap-nhat-nha-cung-cap" data-parsley-validate>
            @csrf
            <div class="row">
                <input type="hidden" name="id" value="{{ $nhaCungCap->id }}"/>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" class="form-control" name="ho_ten" value="{{ $nhaCungCap->ho_ten }}" required data-parsley-required-message="Vui lòng nhập họ tên">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ $nhaCungCap->email }}" required data-parsley-required-message="Vui lòng nhập email" data-parsley-type="email" data-parsley-type-message="Email không đúng định dạng">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="so_dien_thoai" value="{{ $nhaCungCap->so_dien_thoai }}" required data-parsley-required-message="Vui lòng nhập số điện thoại">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" class="form-control" name="dia_chi" value="{{ $nhaCungCap->dia_chi }}" required data-parsley-required-message="Vui lòng nhập địa chỉ">
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Cập nhật</button>
        </form>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-cap-nhat-nha-cung-cap').parsley().validate()) {
        var formData = new FormData();
        $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
        $("input[name='ho_ten']").map(function(){ formData.append('ho_ten', this.value)}).get();
        $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();
        $("input[name='so_dien_thoai']").map(function(){ formData.append('so_dien_thoai', this.value)}).get();
        $("input[name='dia_chi']").map(function(){ formData.append('dia_chi', this.value)}).get();

        $.ajax({
            url: "{{ route('nha_cung_cap.update') }}",
            type: 'POST',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: 'json',
        }).done(function(res) {
            if (res.success) {
                swal.fire({
                    title: res.message,
                    icon: 'success',
                    showCancelButton: false,
                    showConfirmButton: false,
                    position: 'center',
                    padding: '2em',
                    timer: 1500,
                }).then((result) => {
                    window.location.replace(res.redirect)
                })
            }else {
                Swal.fire({
                    title: res.message,
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    position: 'center',
                    padding: '2em',
                    timer: 1500,
                })
            }
        });
        }
    });
</script>
@endsection
