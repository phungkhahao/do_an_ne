@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-them-hoa-don-nhap" data-parsley-validate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Ngày nhập</label>
                    <input type="date" class="form-control" name="ngay_nhap" required data-parsley-required-message="Vui lòng nhập ngày" value="{{  \Carbon\Carbon::now()->format('Y-m-d') }}">
                </div>
                <div class="col-md-6 col-sm-12 mb-3 align-self-end">
                    <a href="#" id="btn-them-san-pham" class="btn btn-primary mt-2 mt-lg-1 ms-3">
                        <i class="bx bxs-plus-square"></i>Thêm sản phẩm
                    </a>                
                </div>

                <div class="col-md-12">
                    <h5>Danh sách sản phẩm</h5>
                </div>
                <div class="col-md-12 mt-1" id="ds-san-pham">
                    <div class="san-pham-row">
                        <div class="row mb-2">
                            <div class="col-md-4">Sản phẩm</div>
                            <div class="col-md-2">Số lượng</div>
                            <div class="col-md-2">Giá nhập</div>
                            <div class="col-md-2">Giá bán</div>
                            <div class="col-md-2"></div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-select mb-3 san-pham select-san-pham"
                                        data-attribute="1"
                                        id="san-pham-1" 
                                        name="san_pham" 
                                        required data-parsley-required-message="Vui lòng chọn sản phẩm">
                                        <option value=""></option>
                                        @foreach ($dsSanPham as $sanPham)
                                            <option value="{{ $sanPham->id }}">{{ $sanPham->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="so-luong" name="so_luong" required data-parsley-required-message="Vui lòng nhập số lượng" value="1">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="gia-nhap" name="gia_nhap" required data-parsley-required-message="Vui lòng nhập giá nhập" value="0">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="gia-ban" name="gia_ban" required data-parsley-required-message="Vui lòng nhập giá bán" value="0">
                                </div>
                                <div class="col-md-2">
                                    <a href="#" id="btn-xoa-san-pham" onClick="xoaSanPham(this)" class="btn btn-danger ms-3">
                                        <i class="bx bxs-plus-square"></i>Xóa
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea type="text" class="form-control" name="ghi_chu" placeholder="Ghi chí" required data-parsley-required-message="Vui lòng nhập ghi chú"></textarea>
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Lưu</button>
        </form>
    </div>
</div>
@endsection
@section('page-js')
<script>
      $("#san-pham-1").select2({
        placeholder: "Chọn sản phẩm",
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
    $('#btn-them-san-pham').click(function (e) { 

        var dsSanPham = @json($dsSanPham);
        let maxAttribute = 0;

        $('.select-san-pham').each(function() {
            let attributeValue = parseInt($(this).attr('data-attribute'));

            if (attributeValue > maxAttribute) {
                maxAttribute = attributeValue;
            }
        });

        console.log(maxAttribute)
        var str = `<div class="san-pham-row"><div class="row mb-2">
                        <div class="col-md-4">Sản phẩm</div>
                        <div class="col-md-2">Số lượng</div>
                        <div class="col-md-2">Giá nhập</div>
                        <div class="col-md-2">Giá bán</div>
                        <div class="col-md-2"></div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-select mb-3 san-pham select-san-pham"
                                    data-attribute="${maxAttribute + 1}" 
                                    id="san-pham-${maxAttribute + 1}" 
                                    name="san_pham" 
                                    required data-parsley-required-message="Vui lòng chọn sản phẩm">
                                    <option value=""></option>`
                                    $.map(dsSanPham, function (element, index) {
                                        str += `<option value="${element.id}">${element.ten}</option>`
                                    });
        str += `</select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="so-luong" name="so_luong" required data-parsley-required-message="Vui lòng nhập số lượng" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="gia-nhap" name="gia_nhap" required data-parsley-required-message="Vui lòng nhập giá nhập" value="0">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="gia-ban" name="gia_ban" required data-parsley-required-message="Vui lòng nhập giá bán" value="0">
                    </div>
                    <div class="col-md-2">
                        <a href="#" id="btn-xoa-san-pham" onClick="xoaSanPham(this)" class="btn btn-danger ms-3">
                            <i class="bx bxs-plus-square"></i>Xóa
                        </a> 
                    </div>
                </div>
            </div></div>`
        $("#ds-san-pham").append(str);
        
        selectSanPham(maxAttribute + 1)
    });

    function selectSanPham(index) {
        $("#" + "san-pham-" + index).select2({
            placeholder: "Chọn sản phẩm",
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
    }

    function xoaSanPham(a) { 
        $(a).closest('.san-pham-row').remove();
    }
</script>
<script>
    function isDuplicateSanPham(dsSanPham, san_pham) {
        return dsSanPham.some(function(item) {
            return item.san_pham === san_pham;
        });
    }

    $('#btn-submit-form').click(function() {
        if($('#frm-them-hoa-don-nhap').parsley().validate()) {
        var formData = new FormData();

        // let dsSanPham = $('.san-pham-row').map(function() {
        //     return {
        //         san_pham: $(this).find('select[name="san_pham"]').val(),
        //         so_luong: $(this).find('input[name="so_luong"]').val(),
        //         gia_nhap: $(this).find('input[name="gia_nhap"]').val(),
        //         gia_ban: $(this).find('input[name="gia_ban"]').val()
        //     };
        // }).get();
        let dsSanPham = [];
        $('.san-pham-row').each(function() {
            let san_pham = $(this).find('select[name="san_pham"]').val();
            let so_luong = $(this).find('input[name="so_luong"]').val();
            let gia_nhap = $(this).find('input[name="gia_nhap"]').val();
            let gia_ban = $(this).find('input[name="gia_ban"]').val();

            // Kiểm tra số lượng
            if (so_luong <= 0) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Số lượng sản phẩm phải lớn hơn 0.',
                    icon: 'error',
                    confirmButtonText: 'Đóng'
                });
                return; 
            }

            // Kiểm tra trùng sản phẩm
            if (isDuplicateSanPham(dsSanPham, san_pham)) {
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Sản phẩm đã tồn tại trong danh sách.',
                    icon: 'error',
                    confirmButtonText: 'Đóng'
                });
                return; 
            }
        
            dsSanPham.push({
                san_pham: san_pham,
                so_luong: so_luong,
                gia_nhap: gia_nhap,
                gia_ban: gia_ban
            });
        });


        console.log(dsSanPham);
        formData.append('dsSanPham', JSON.stringify(dsSanPham));

        $("input[name='ngay_nhap']").map(function(){ formData.append('ma', this.value)}).get();
        $.ajax({
            url: "{{ route('nhap_hang.store') }}",
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
