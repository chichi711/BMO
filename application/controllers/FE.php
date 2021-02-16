<?php

use phpDocumentor\Reflection\Location;

class FE extends CI_Controller{

    
    public function index()
    {
        $data = array(
            'title' => 'BMO',
            'path'=>'fe/index',
            "active"=>'BMO',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    // 分類
    public function books()
    {
        $data = array(
            'title' => '中文書',
            'path'=>'fe/product_list',
            "active"=>'books',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    public function fbooks()
    {
        $data = array(
            'title' => '外文書',
            'path'=>'fe/product_list',
            "active"=>'fbooks',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    public function magazine()
    {
        $data = array(
            'title' => '雜誌',
            'path'=>'fe/product_list',
            "active"=>'magazine',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    public function mook()
    {
        $data = array(
            'title' => 'MOOK',
            'path'=>'fe/product_list',
            "active"=>'mook',
        );
        $this->load->view('fe/templates/layout',$data);
    }
    
    public function product($id = '')
    {
        // hub
        $data = array(
            'title' => '商品',
            'path'=>'fe/product',
            "active"=>'product',
            "id"=>$id,
        );
        $this->load->view('fe/templates/layout',$data);
    }
    // 登入登出
    public function login()
    {
        $data = array(
            'title' => '登入',
            'path'=>'fe/login',
            "active"=>'登入 / 註冊',
        );
        $this->load->view('fe/templates/layout',$data);
    }
    public function logout()
    {
        $this->mod_user->do_logout();
        redirect(base_url('./'));
    }
    public function cart_list()
    {
        if(!$this->mod_user->chk_login_status()) redirect(base_url('./login'));
        $data = array(
            'title' => '購物車',
            'path'=>  'fe/cart',
            "active"=>'購物車',
        );
        $this->load->view('fe/templates/layout',$data);
    }
    
    public function profile()
    {
        $data = array(
            'title' => '個人資料',
            'path'=>'fe/profile',
            "active"=>'個人資料',
        );
        $this->load->view('fe/templates/layout',$data);
    }
}