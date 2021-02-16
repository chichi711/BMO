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
        redirect(base_url('./admin'));
    }
    /********************************
     * 
     * class
     */
    public function main_class()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '大分類',
            'path'=>'admin/class/main'
        );
        $this->load->view('admin/templates/layout',$view);
    }
    public function sub_class()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '小分類',
            'path'=>'admin/class/sub'
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
    public function product_list()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '商品列表',
            'path'=>'admin/product/list',
        );
        $this->load->view('admin/templates/layout',$view);
    }

    public function product_set()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '編輯商品',
            'path'=>'admin/product/set',
        );
        $this->load->view('admin/templates/layout',$view);
    }
    /********************************
     * 
     * order
     */
    public function order_list()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '訂單列表',
            'path'=>'admin/order/list',
        );
        $this->load->view('admin/templates/layout',$view);
    }

    public function order_set()
    {
        $this->mod_manager->chk_login_status();
        $view = array(
            'title' => '編輯訂單',
            'path'=>'admin/order/set',
        );
        $this->load->view('admin/templates/layout',$view);
    }



}