<!DOCTYPE html>
<html>

<head>
	<base href="<?= base_url() ?>">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?> | BMO</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./public/admin_assets/img/BmoLogo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="./public/admin_assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="./public/admin_assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <!-- <link rel="stylesheet" href="./public/admin_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
    <!-- JQVMap -->
    <!-- <link rel="stylesheet" href="./public/admin_assets/plugins/jqvmap/jqvmap.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="./public/admin_assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <!-- <link rel="stylesheet" href="./public/admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> -->
    <!-- Daterange picker -->
    <!-- <link rel="stylesheet" href="./public/admin_assets/plugins/daterangepicker/daterangepicker.css"> -->
    <!-- summernote -->
    <link rel="stylesheet" href="./public/admin_assets/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="./public/admin_assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./public/admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- jQuery -->
    <script src="./public/admin_assets/plugins/jquery/jquery.min.js"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <!-- Qs -->
    <script src="https://cdn.bootcss.com/qs/6.7.0/qs.min.js"></script>
    <!-- axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>



    <link rel="stylesheet" href="./public/admin_assets/css/zu.css">
    <!-- common -->
    <script src="./public/admin_assets/js/common.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <h4 class="navbar-text"><?= $title ?></h4>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <?php $this->load->view('admin/templates/left_menu') ?>