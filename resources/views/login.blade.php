<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  <link href="{{ asset('assets/plugins/parsley/parsley.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">

</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="">
                </a>
                <form id="frm-dang-nhap" data-parsley-validate>
                  @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required data-parsley-required-message="Vui lòng nhập tên đăng nhập">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required data-parsley-required-message="Vui lòng nhập mật khẩu"                    >
                  </div>
                  <button id="btn-submit-form" type="button" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/parsley/parsley.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.bundle.js') }}"></script>

  <script>
    $('#btn-submit-form').click(function() {
      if($('#frm-dang-nhap').parsley().validate()) {
        var formData = new FormData();
        $("input[name='username']").map(function(){ formData.append('username', this.value)}).get();
        $("input[name='password']").map(function(){ formData.append('password', this.value)}).get();
        console.log( $('meta[name="csrf-token"]').attr('content'))
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url: "{{ route('do_login') }}",
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
</body>

</html>
