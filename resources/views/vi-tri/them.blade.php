@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-them-vi-tri" data-parsley-validate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Mã vị trí</label>
                    <input type="text" class="form-control" name="ma" required data-parsley-required-message="Vui lòng nhập mã vị trí">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Tên sản phầm</label>
                    <input type="text" class="form-control" name="ten" required data-parsley-required-message="Vui lòng nhập tên vị trí">
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Thêm</button>
        </form>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-vi-tri').parsley().validate()) {
        var formData = new FormData();
        $("input[name='ma']").map(function(){ formData.append('ma', this.value)}).get();
        $("input[name='ten']").map(function(){ formData.append('ten', this.value)}).get();
        $.ajax({
            url: "{{ route('vi_tri.store') }}",
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
