

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/admin/index" class="brand-link">
                <img src="/public/admin_assets/img/BmoLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">BMO Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/public/admin_assets/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <span href="#" class="d-block text-grey"><?=$_SESSION['manager_name']?>（ <?= $this->config->item('manager_level')[$_SESSION['level']]?> ）</span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <?php switch ($this->session->userdata('level')) {
                            case '0':
                                ?>
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    選單
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/admin/main_class" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>主分類</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/sub_class" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>次分類</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/admin/third_class" class="nav-link">
                                        <i class="nav-icon far fa-circle"></i>
                                        <p>小分類</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fab fa-product-hunt"></i>
                                <p>商品列表</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>折扣設定(每日66折)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>圖表</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fas fa-comment"></i>
                                <p>會員訊息</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fas fa-tag"></i>
                                <p>標籤列表</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/index" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>會員管理</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/manager_list" class="nav-link">
                                <i class="nav-icon fas fa-user-alt"></i>
                                <p>
                                    帳號管理
                                </p>
                            </a>
                        </li>
                        <?php
                            break;
                        case '1':
                            ?>

                        <?php
                            break;
                        case '2':
                            ?>

                            <?php
                            break;
                        }?>
                        <li class="nav-item">
                            <a href="/admin/logout" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    登出
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper pt-3">


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">