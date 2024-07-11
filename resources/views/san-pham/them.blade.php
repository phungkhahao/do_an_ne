@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-them-san-pham" data-parsley-validate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Mã sản phẩm</label>
                    <input type="text" class="form-control" name="ma" placeholder="Mã sản phẩm" required data-parsley-required-message="Vui lòng nhập mã sản phẩm">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Tên sản phầm</label>
                    <input type="text" class="form-control" name="ten" placeholder="Tên sản phẩm" required data-parsley-required-message="Vui lòng nhập tên sản phẩm">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Nhà cung cấp</label>
                    <select class="form-select mb-3"
                        id="nha-cung-cap" 
                        name="nha_cung_cap" 
                        required data-parsley-required-message="Vui lòng chọn nhà cung cấp">
                        <option value=""></option>
                        @foreach ($dsNhaCungCap as $nhaCungCap)
                            <option value="{{ $nhaCungCap->id }}">{{ $nhaCungCap->ho_ten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea type="text" class="form-control" name="mo_ta" placeholder="Mô tả" required data-parsley-required-message="Vui lòng nhập mô tả sản phẩm"></textarea>
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Thêm</button>
        </form>
    </div>
</div>
@endsection
@section('page-js')
<script>
    $("#nha-cung-cap").select2({
        placeholder: "Chọn nhà cung cấp",
        width: '100%',
        closeOnSelect : true,
        allowClear: true,
        tags: false,
        language: {
            noResults: function (params) {
                return "Không tìm thấy kết quả";
            }
        },
    });
</script>
<script>
    $('#btn-submit-form').click(function() {
        if($('#frm-them-san-pham').parsley().validate()) {
        var formData = new FormData();
        $("input[name='ma']").map(function(){ formData.append('ma', this.value)}).get();
        $("input[name='ten']").map(function(){ formData.append('ten', this.value)}).get();
        $("textarea[name='mo_ta']").map(function(){ formData.append('mo_ta', this.value)}).get();
        $("select[name='nha_cung_cap']").map(function(){ formData.append('nha_cung_cap', this.value)}).get();
        $.ajax({
            url: "{{ route('san_pham.store') }}",
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
