<div class="modal fade" id="update-pass-modal" tabindex="-1"  aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="update_form" data-parsley-validate id="frm-cap-nhat-mk" >
                    @csrf
                    <div class="mb-3">
						<label class="form-label" for="mo-ta">Mật khẩu</label>
						<input type="password" class="form-control" id="password" name="password" required data-parsley-required-message="Vui lòng nhập mật khẩu cũ">
					</div>
					<div class="mb-3">
						<label class="form-label" for="mo-ta">Mật khẩu mới</label>
						<input type="password" class="form-control" id="new_password" name="new_password" required data-parsley-required-message="Vui lòng nhập mật khẩu mới">
					</div>
					<div class="mb-3">
						<label class="form-label" for="mo-ta">Xác nhận mật khẩu</label>
						<input type="password" class="form-control" od="enter_new_pass" name="enter_new_pass" required data-parsley-required-message="Vui lòng nhập lại mật khẩu mới" data-parsley-equalto="#new_password" data-parsley-equalto-message="Mật khẩu không khớp">
					</div>
                    <div class="d-lg-flex justify-content-end">
						<button id="btn-update-pass-modal" type="button" class="btn btn-primary ms-3">Lưu</button>
                        <button type="button" class="btn btn-outline-primary ms-2" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

