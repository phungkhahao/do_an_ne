@extends('master')
@section('page-content')
<div class="card d-flex ">
    <div class="card-body">
        <div class="d-lg-flex justify-content-end mb-3">
            <a onclick="updatePass(this)" id="btn-update-pass" class="btn btn-primary mt-2 mt-lg-1"  onclick="updatePass(this)">
                <i class="bx bxs-plus-square"></i>Đổi mật khẩu
            </a>
        </div>
        <form id="frm-cap-nhat-tai-khoan" data-parsley-validate>
            @csrf
            <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" class="form-control" name="ho_ten" value="{{ Auth::user()->ho_ten }}" required data-parsley-required-message="Vui lòng nhập họ tên">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required data-parsley-required-message="Vui lòng nhập email" data-parsley-type="email" data-parsley-type-message="Email không đúng định dạng">
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}" disabled>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" name="so_dien_thoai" value="{{ Auth::user()->sdt }}" required data-parsley-required-message="Vui lòng nhập số điện thoại">
                </div>
            </div>
            <button style="width: fit-content" id="btn-submit-form" type="button" class="btn btn-primary py-8 fs-4 mb-4 rounded-2">Cập nhật</button>
        </form>
    </div>
</div>
@include('thong-tin-tai-khoan.cap-nhat-mat-khau')

@endsection
@section('page-js')
<script>
    function updatePass(a) {
        var modal = $("#update-pass-modal");
        modal.modal('show')
        modal.on('shown.bs.modal', function(e) {
        });
        modal.on('hidden.bs.modal', function() {
            $('#frm-cap-nhat-mk').parsley().reset();
            $('#frm-cap-nhat-mk').trigger("reset")
        });
    };

    $('#btn-submit-form').click(function() {
        if($('#frm-cap-nhat-tai-khoan').parsley().validate()) {
        var formData = new FormData();
        $("input[name='ho_ten']").map(function(){ formData.append('ho_ten', this.value)}).get();
        $("input[name='email']").map(function(){ formData.append('email', this.value)}).get();
        $("input[name='so_dien_thoai']").map(function(){ formData.append('sdt', this.value)}).get();
        $.ajax({
            url: "{{ route('cap_nhat_tai_khoan') }}",
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

    $('#btn-update-pass-modal').click(function() {
		if($('#frm-cap-nhat-mk').parsley().validate()) {
			var formData = new FormData();
			$("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
			$("input[name='new_password']").map(function(){ formData.append('new_password', this.value)}).get();
			$("input[name='enter_new_pass']").map(function(){ formData.append('enter_new_pass', this.value)}).get();
			$.ajax({
				url: "{{ route('cap_nhat_mat_khau') }}",
				type: 'POST',
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
				dataType: 'json',
			}).done(function(res) {
				if (res.status == 'success') {
					swal.fire({
						title: res.message,
						icon: 'success',
						showCancelButton: false,
						showConfirmButton: false,
						position: 'center',
						padding: '2em',
						timer: 1500,
					})
                    $("#update-pass-modal").modal('hide')
				} else {
					$('#frm-cap-nhat-mk').parsley().reset();
            		$('#frm-cap-nhat-mk').trigger("reset")
					Swal.fire({
						title: res.message,
						icon: res.status,
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
