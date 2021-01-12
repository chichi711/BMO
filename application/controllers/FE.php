<?php
class FE extends CI_Controller{

    
    public function index(){
        $data['title'] = 'BMO';
        $data['keywords'] = 'BMO';
        $data['file'] = 'fe/index';
        return view('templates/fe/layout',$data);
    }
}