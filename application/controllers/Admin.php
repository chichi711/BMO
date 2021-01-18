<?php
class Admin extends CI_Controller{

    
    public function login() {
        $data['title'] = 'bmo 管理平台登入';
        return view('admin/login',$data);
    }
    public function logout(){
        $this->session->remove('manager');
        return redirect()->to('./admin_bmo/login');   
    }

    public function index(){
        echo 'qq';
        if(!$this->Mod_manager->chk_login_status()){return redirect()->to('./admin_bmo/login');}
        $data['title'] = '管理平台首頁';
        
        return view('admin/index',$data);
    }

}