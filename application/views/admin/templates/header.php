<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title;?> | BMO 系統管理後台</title>
  <base href="<?=base_url()?>">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./public/admin_assets/plugins/fontawesome-free/css/all.min.css">
  <!-- pace-progress -->
  <link rel="stylesheet" href="./public/admin_assets/plugins/pace-progress/themes/black/pace-theme-flat-top.css">
  <!-- adminlte-->
  <link rel="stylesheet" href="./public/admin_assets/css/adminlte.min.css">
  <link rel="stylesheet" href="./public/admin_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

  <!-- jQuery -->
  <script src="./public/admin_assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./public/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- pace-progress -->
  <script src="./public/admin_assets/plugins/pace-progress/pace.min.js"></script>

  <script src="./public/admin_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./public/admin_assets/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="./public/admin_assets/js/demo.js"></script>

<!-- sweetalert2 -->
<link rel="stylesheet" href="./public/admin_assets/plugins/sweetalert2/sweetalert2.min.css">
<script src="./public/admin_assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Vue -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!-- axios -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


</head>
<body class="hold-transition sidebar-mini pace-primary">
<!-- Site wrapper -->
<div class="wrapper">
  



  <!-- Main Sidebar Container -->
  <?php $this->load->view('admin/templates/left_menu');?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">


