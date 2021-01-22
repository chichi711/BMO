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
            'title' => 'Banner',
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
        $view = array(
            'title' => 'BMO 管理後台',
            'path'=>'admin/logout'
        );
        $this->session->remove('manager');
        $this->load->view('admin/logout', $view);
    }
    /********************************
     * 
     * class
     */
    public function main_class()
    {
        $view = array(
            'title' => 'BMO 管理後台',
            'path'=>'admin/class/main'
        );
        $this->load->view('admin/templates/layout',$view);
    }



}