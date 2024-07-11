@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-cap-nhat-san-pham" data-parsley-validate>
            @csrf
            <div class="row">
                <input type="hidden" name="id" value="{{ $sanPham->id }}"/>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Mã sản phẩm</label>
                    <input type="text" class="form-control" name="ma" value="{{ $sanPham->ma }}" required data-parsley-required-message="Vui lòng nhập mã sản phẩm">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Tên sản phầm</label>
                    <input type="text" class="form-control" name="ten" value="{{ $sanPham->ten }}" required data-parsley-required-message="Vui lòng nhập tên sản phẩm">
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea type="text" class="form-control" name="mo_ta" required data-parsley-required-message="Vui lòng nhập mô tả sản phẩm">{{ $sanPham->mo_ta }}</textarea>
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
        if($('#frm-cap-nhat-san-pham').parsley().validate()) {
        var formData = new FormData();
        $("input[name='id']").map(function(){ formData.append('id', this.value)}).get();
        $("input[name='ma']").map(function(){ formData.append('ma', this.value)}).get();
        $("input[name='ten']").map(function(){ formData.append('ten', this.value)}).get();
        $("textarea[name='mo_ta']").map(function(){ formData.append('mo_ta', this.value)}).get();
        $.ajax({
            url: "{{ route('san_pham.update') }}",
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
