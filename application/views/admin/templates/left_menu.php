<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="./admin_bmo/" class="brand-link">
      <span class="brand-text font-weight-light">BMO Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="./admin_assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <a href="javascript: void(0)" >hi! <?=$_SESSION['manager']['manager_name']?> 歡迎回來</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         
          <li class="nav-item">
            <a href="./admin_iav/banners" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    首頁 Banner
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="./admin_iav/logout" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    登出
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
          </li>
          
          
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>