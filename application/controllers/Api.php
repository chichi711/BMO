<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller{

     /*******************************
     * 
     * 
     * 管理員
     * 0,管理者(總公司) 
        1,業務主管(門市主管)
        2,業務
        3,行銷企劃
     * 
     */
    function manager_login(){
        $getpost = array('manager_id','manager_pwd');
        $requred = array('manager_id','manager_pwd');
        $data = $this->getpost->get_post_json($getpost, $requred);
        // if($this->mod_manager->chk_login($data['manager_id'],$data['manager_pwd'])){
            $this->mod_manager->do_login($data['manager_id']);
            $json_arr['session'] = $this->session->all_userdata();
            $this->api_msg->show('200','success',$json_arr);
        // }else{
            // $this->api_msg->show('500','Login Failed');
        // }
    }
    function manager_logout(){
        $this->mod_manager->do_logout();
        $this->api_msg->show('200','success');
    }

    function manager_list(){
        $store = $this->input->get_post('store');
        if($store != ""){
            $this->db->where('store',$store);
        }
        $level = $this->input->get_post('level');
        if($level != ""){
            $this->db->where('level',$level);
        }
        $datalist = [];
        foreach ($this->db->select('manager_id,manager_name,last_datetime,level,store')->get('manager_main')->result_array() as $key => $value) {
            $datalist[$key]=$value;
            $datalist[$key]['store_name']=$this->mod_db->get_once_col_value(array('sn'=>$value['store']),'store','store_name');
        }
        $data['list'] =$datalist;
        $this->api_msg->show('200','Success',$data);
    }
}