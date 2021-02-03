<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller{

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => 'BMO 系統管理後台',
            'path'=>'admin/index'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    public function login()
    {
        $view = array(
            'title' => 'BMO 管理後台',
            'path'=>'admin/login'
        );
        $this->load->view('admin/login', $view);
    }
    public function logout()
    {
        $this->mod_manager->do_logout();
        $view = array(
            'title' => 'BMO 管理後台',
            'path'=>'admin/login'
        );
        $this->load->view('admin/login', $view);
    }
    /********************************
     * 
     * class
     */
    public function main_class()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '主分類',
            'path'=>'admin/class/main'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    public function sub_class()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '次分類',
            'path'=>'admin/class/sub'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    public function third_class()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '小分類',
            'path'=>'admin/class/third'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    /********************************
     * 
     * manager
     */
    public function manager_list()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '帳號管理',
            'path'=>'admin/manager/list'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    /********************************
     * 
     * product
     */
    public function product_list($type = 1)
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '商品列表',
            'path'=>'admin/product/list',
            'main_id' => $type
        );
        $this->load->view('admin/templates/layout',$view);
    }



}