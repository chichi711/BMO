<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BMO 管理平台</title>
  <base href="<?= base_url() ?>">

  <!-- sweetalert2 -->
  <link rel="stylesheet" href="./public/admin_assets/plugins/sweetalert2/sweetalert2.min.css">
  <script src="./public/admin_assets/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./public/admin_assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./public/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./public/admin_assets/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>BMO</b> 管理平台
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">

        <form action="../../index3.html" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Manager ID" id="manager_id">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Manager Password" id="manager_pwd">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">

            <div class="col-4">
              <button type="button" class="btn btn-primary btn-block" id="sign_in">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="./public/admin_assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./public/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./public/admin_assets/js/adminlte.min.js"></script>


  <script>
    $(function() {
      $("body").on('click', '#sign_in', function() {
        var api = './api/manager_login';
          $.post(api, {
            manager_id: $("#manager_id").val(),
            manager_pwd: $("#manager_pwd").val(),
          }, function(data) {
            console.log(data);
            if (data.sys_code == '200') {
              location.href = "./admin/index";
            } else {
              swal.fire(data.sys_msg);
            }
          }, 'json');
      })
    })
  </script>
</body>

</html>