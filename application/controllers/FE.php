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

    public function news()
    {
        // hub
        $data = array(
            'title' => 'product',
            'path'=>'fe/product',
            "active"=>'product',
        );
        $this->load->view('fe/templates/layout',$data);
    }
}