<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Api extends CI_Controller{

     /*******************************
     * 
     * 
     * 管理員
     * 
     * 
     */
    function manager_login(){
        $getpost = array('manager_id','manager_pwd');
        $requred = array('manager_id','manager_pwd');
        $data = $this->getpost->get_post_json($getpost, $requred);
        if($this->mod_manager->chk_login($data['manager_id'],$data['manager_pwd'])){
            $this->mod_manager->do_login($data['manager_id']);
            $json_arr['session'] = $this->session->all_userdata();
            $this->api_msg->show('200','success',$json_arr);
        }else{
            $this->api_msg->show('500','Login Failed');
        }
    }

    function manager_list(){
        $data = $this->db->order_by('level','asc')->get('manager_main')->result_array();
        $this->api_msg->show('200','Success',$data);
    }
    function manager_add(){
        $getpost = array('manager_id','manager_pwd','manager_name','level');
        $requred = array('manager_id','manager_pwd','manager_name','level');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        // 檢查重複
        $where = array('manager_id'=>$data['manager_id']);
        $this->mod_apicheck->chk_repeat($where,'manager_main','帳號重複');
        $this->db->insert('manager_main',$data);
        $this->api_msg->show('200','Success');
    }
    function manager_info(){
        $getpost = array('manager_id');
        $requred = array('manager_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id'=>$data['manager_id']);
        $this->mod_apicheck->chk_data($where,'manager_main','帳號不存在');
        $this->db->where($where);
        $json_data['data'] = $this->db->select('manager_id,manager_name,lavel,last_datetime')->get('manager_main')->row_array();
        $this->api_msg->show('200','Success',$json_data);
    }
    function manager_edit(){
        $getpost = array('manager_id','manager_name','manager_pwd','level');
        $requred = array('manager_id','manager_name','manager_pwd','level');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id'=>$data['manager_id']);
        $this->mod_apicheck->chk_data($where,'manager_main','帳號不存在');
        $this->db->where($where);
        unset($data['manager_id']);
        $this->db->update('manager_main',$data);
        $this->api_msg->show('200','Success');
    }
    function manager_remove(){
        $getpost = array('manager_id');
        $requred = array('manager_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id'=>$data['manager_id']);
        $this->mod_apicheck->chk_data($where,'manager_main','帳號不存在');
        $this->db->where($where)->delete('manager_main');
        $this->api_msg->show('200','Success');
    }

   /******************************
     * 
     * 公告欄
     * bulletin
     */
    // 新增修改
    function bulletin_set(){
        $input = array('manager_id','info','subject','sn');
        $request = array('manager_id','subject','info');
        $data = $this->mod_apicheck->chk_get_post_requred($input,$request);
        if($data['sn'] == ''){
            $where['sn'] = uniqid();
        }else{
            $where['sn'] = $data['sn'];
        }
        unset($data['sn']);
        $data['update_datetime'] = date("Y-m-d H:i:s");
        $this->mod_db->insert_or_update($where,$data,'bulletin');
        $this->api_msg->show('200');
    }
    // 列表
    function bulletin_list(){
        $datalist = array();
        foreach ($this->db->order_by('update_datetime','desc')->get('bulletin')->result_array() as $key => $value) {
            $datalist[$key] = $value;
            $datalist[$key]['html_info'] = nl2br($value['info']);
        }
        $this->api_msg->show('200','',$datalist);

    }
    // 刪除
    function bulletin_remove(){
        $getpost = array('sn');
        $requred = array('sn');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost,$requred);
        $this->db->where('sn',$data['sn'])->delete('bulletin');
        $this->api_msg->show('200');
    }
}