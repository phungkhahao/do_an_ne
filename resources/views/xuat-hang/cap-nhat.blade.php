@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <form id="frm-cap-nhat-hoa-don-nhap" data-parsley-validate>
            @csrf
            <div class="row">
                <input type="hidden" name="xuat_hang_id" value="{{$donHang->id}}">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Ngày nhập</label>
                    <input type="date" class="form-control" name="ngay_xuat" required data-parsley-required-message="Vui lòng nhập ngày" value="{{ $donHang->ngay_xuat }}">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Khách hàng</label>
                    <select class="form-select mb-3 san-pham select-san-pham"
                        id="khach-hang" 
                        name="khach_hang" 
                        data-parsley-errors-container="#error-parley-khach-hang"
                        required data-parsley-required-message="Vui lòng chọn khách hàng">
                        <option value=""></option>
                        @foreach ($dsKhachHang as $khachHang)
                            <option  @if($khachHang->id==$donHang->khach_hang_id) selected @endif  value="{{ $khachHang->id }}">{{ $khachHang->ho_ten }}</option>
                        @endforeach
                    </select>
                    <div id="error-parley-khach-hang"></div>                
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
                    @foreach ( $donHang->chi_tiet as $key => $chiTiet)
                        <div class="san-pham-row">
                            <div class="row mb-2">
                                <div class="col-md-4">Sản phẩm</div>
                                <div class="col-md-2">Số lượng</div>
                                <div class="col-md-2">Giá bán</div>
                                <div class="col-md-2"></div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-select mb-3 san-pham select-san-pham"
                                            data-attribute="{{$key + 1}}"
                                            id="san-pham-{{$key+1}}" 
                                            name="san_pham" 
                                            data-parsley-errors-container="#error-parley-san-pham-{{$key + 1}}"
                                            required data-parsley-required-message="Vui lòng chọn sản phẩm">
                                            <option value=""></option>
                                            @foreach ($dsKhoHang as $khoHang)
                                                <option @if($khoHang->id == $chiTiet->kho_hang_id) selected @endif value="{{ $khoHang->id }}">{{ $khoHang->san_pham->ten }} ({{ "DX".str_pad($khoHang->idNhapHang, 8, "0", STR_PAD_LEFT) }})</option>
                                            @endforeach
                                        </select>
                                        <div id="error-parley-san-pham-{{ $key + 1 }}"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" id="so-luong" onblur="tinhTongTien(this)" oninput="tinhTongTien(this)" onchange="tinhTongTien(this)" name="so_luong" required data-parsley-required-message="Vui lòng nhập số lượng" value="{{ $chiTiet->so_luong }}">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" disabled class="form-control" id="gia-ban-goi-y" name="gia_ban_goi_y">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" id="gia-ban" onblur="tinhTongTien(this)" oninput="tinhTongTien(this)" onchange="tinhTongTien(this)" name="gia_ban" required data-parsley-required-message="Vui lòng nhập giá bán" value="{{ $chiTiet->don_gia }}">
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" id="btn-xoa-san-pham" onClick="xoaSanPham(this)" class="btn btn-danger ms-3">
                                            <i class="bx bxs-plus-square"></i>Xóa
                                        </a> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                    <h5 id="tong-tien">Tổng tiền: <span>{{ $donHang->tong_tien }}</span></h5>
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Lưu</button>
        </form>
    </div>
</div>
@endsection
@section('page-js')
<script>
    var soLuongChiTiet = @json(count($donHang->chi_tiet));
</script>
<script>
    $(document).ready(function() {      
        for( var i = 1; i <= soLuongChiTiet; i++){
            $("#san-pham-" + i).select2({
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
    })
</script>

<script>
    function tinhTongTien() {
        var tongTienTatCa = 0;
        $('.san-pham-row').each(function() {
            let san_pham = $(this).find('select[name="san_pham"]').val();
            let so_luong = $(this).find('input[name="so_luong"]').val();
            let gia_ban = $(this).find('input[name="gia_ban"]').val();
            tongTienTatCa += Number(so_luong) * Number(gia_ban);

        });
        $('#tong-tien span').html(tongTienTatCa);
    }
</script>
<script>
    $('#btn-them-san-pham').click(function (e) { 

        var dsKhoHang = @json($dsKhoHang);
        let maxAttribute = 0;

        $('.select-san-pham').each(function() {
            let attributeValue = parseInt($(this).attr('data-attribute'));

            if (attributeValue > maxAttribute) {
                maxAttribute = attributeValue;
            }
        });

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
                                    data-parsley-errors-container="#error-parley-san-pham-${maxAttribute + 1}"
                                    required data-parsley-required-message="Vui lòng chọn sản phẩm">
                                    <option value=""></option>`
                                    $.map(dsKhoHang, function (element, index) {
                                        str += `<option value="${element.id}">${element.san_pham.ten} (${ "DX" + padNumber(element.idNhapHang, 8, "0") })</option>`
                                    });
                str += `</select>
                <div id="error-parley-san-pham-${maxAttribute + 1}"></div>

                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" onblur="tinhTongTien(this)" oninput="tinhTongTien(this)" onchange="tinhTongTien(this)" id="so-luong" name="so_luong" required data-parsley-required-message="Vui lòng nhập số lượng" value="1">
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="gia-ban-goi-y" name="gia_ban_goi_y" disabled>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" onblur="tinhTongTien(this)" oninput="tinhTongTien(this)" onchange="tinhTongTien(this)" id="gia-ban" name="gia_ban" required data-parsley-required-message="Vui lòng nhập giá bán" value="0">
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

    function padNumber(num, width, padChar) {
        padChar = padChar || '0';
        num = num + ''; // Convert to string
        return num.length >= width ? num : new Array(width - num.length + 1).join(padChar) + num;
    }

    function xoaSanPham(a) { 
        $(a).closest('.san-pham-row').remove();
        tinhTongTien()
    }
</script>
<script>
    function isDuplicateSanPham(dsSanPham, san_pham) {
        return dsSanPham.some(function(item) {
            return item.san_pham === san_pham;
        });
    }


    $('#btn-submit-form').click(function() {
        if($('#frm-cap-nhat-hoa-don-nhap').parsley().validate()) {
        var formData = new FormData();

        let dsSanPham = [];
        var flag = true
        $('.san-pham-row').each(function() {
            let san_pham = $(this).find('select[name="san_pham"]').val();
            let so_luong = $(this).find('input[name="so_luong"]').val();
            let gia_ban = $(this).find('input[name="gia_ban"]').val();

            // Kiểm tra số lượng
            if (so_luong <= 0) {
                flag = false
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
                flag = false
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Sản phẩm đã tồn tại trong danh sách.',
                    icon: 'error',
                    confirmButtonText: 'Đóng'
                });
                return; 
            }
        
            dsSanPham.push({
                id: san_pham,
                so_luong: so_luong,
                don_gia: gia_ban
            });
        });

        if(!flag){
            return
        }
        formData.append('dsKhoHang', JSON.stringify(dsSanPham));

        $("input[name='ngay_xuat']").map(function(){ formData.append('ngay_xuat', this.value)}).get();
        $("select[name='khach_hang']").map(function(){ formData.append('khach_hang_id', this.value)}).get();
        $("input[name='xuat_hang_id']").map(function(){ formData.append('xuat_hang_id', this.value)}).get();
        $.ajax({
            url: "{{ route('xuat_hang.update') }}",
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