<?php
class FE extends CI_Controller{

    
    public function index()
    {
        // hub
        $data = array(
            'title' => 'BMO',
            'path'=>'fe/index',
            "active"=>'BMO',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    public function product_list()
    {
        // hub
        $data = array(
            'title' => '商品頁',
            'path'=>'fe/product_list',
            "active"=>'product',
        );
        $this->load->view('fe/templates/layout',$data);
    }

    public function product()
    {
        // hub
        $data = array(
            'title' => '商品',
            'path'=>'fe/product',
            "active"=>'product',
        );
        $this->load->view('fe/templates/layout',$data);
    }
}