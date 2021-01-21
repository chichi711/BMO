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
            'title' => '管理後台',
            'path'=>'admin/index',
            "sub_active"=>''
        );
        $this->load->view('admin/templates/layout',$view);
    }
    public function login()
    {
        $view = array(
            'title' => '管理後台',
            'path'=>'admin/login',
            "sub_active"=>''
        );
        $this->load->view('admin/login', $view);
    }
    public function logout()
    {
        $view = array(
            'title' => '管理後台',
            'path'=>'admin/logout',
            "sub_active"=>''
        );
        $this->session->remove('manager');
        $this->load->view('admin/logout', $view);
    }



}