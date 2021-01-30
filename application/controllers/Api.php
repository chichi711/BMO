<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Api extends CI_Controller
{

    /*******************************
     * 
     * 
     * 管理員
     * 
     * 
     */
    function manager_login()
    {
        $getpost = array('manager_id', 'manager_pwd');
        $requred = array('manager_id', 'manager_pwd');
        $data = $this->getpost->get_post_json($getpost, $requred);
        if ($this->mod_manager->chk_login($data['manager_id'], $data['manager_pwd'])) {
            $this->mod_manager->do_login($data['manager_id']);
            $json_arr['session'] = $this->session->all_userdata();
            $this->api_msg->show('200', 'success', $json_arr);
        } else {
            $this->api_msg->show('500', 'Login Failed');
        }
    }

    function manager_list()
    {
        $data = $this->db->order_by('level', 'asc')->get('manager_main')->result_array();
        $this->api_msg->show('200', 'Success', $data);
    }
    function manager_add()
    {
        $getpost = array('manager_id', 'manager_pwd', 'manager_name', 'level');
        $requred = array('manager_id', 'manager_pwd', 'manager_name', 'level');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        // 檢查重複
        $where = array('manager_id' => $data['manager_id']);
        $this->mod_apicheck->chk_repeat($where, 'manager_main', '帳號重複');
        $this->db->insert('manager_main', $data);
        $this->api_msg->show('200', 'Success');
    }
    function manager_info()
    {
        $getpost = array('manager_id');
        $requred = array('manager_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id' => $data['manager_id']);
        $this->mod_apicheck->chk_data($where, 'manager_main', '帳號不存在');
        $this->db->where($where);
        $json_data['data'] = $this->db->select('manager_id,manager_name,lavel,last_datetime')->get('manager_main')->row_array();
        $this->api_msg->show('200', 'Success', $json_data);
    }
    function manager_edit()
    {
        $getpost = array('manager_id', 'manager_name', 'manager_pwd', 'level');
        $requred = array('manager_id', 'manager_name', 'manager_pwd', 'level');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id' => $data['manager_id']);
        $this->mod_apicheck->chk_data($where, 'manager_main', '帳號不存在');
        $this->db->where($where);
        unset($data['manager_id']);
        $this->db->update('manager_main', $data);
        $this->api_msg->show('200', 'Success');
    }
    function manager_remove()
    {
        $getpost = array('manager_id');
        $requred = array('manager_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('manager_id' => $data['manager_id']);
        $this->mod_apicheck->chk_data($where, 'manager_main', '帳號不存在');
        $this->db->where($where)->delete('manager_main');
        $this->api_msg->show('200', 'Success');
    }

    /******************************
     * 
     * 公告欄
     * bulletin
     */
    // 新增修改
    function bulletin_set()
    {
        $input = array('manager_id', 'info', 'subject', 'sn');
        $request = array('manager_id', 'subject', 'info');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        if ($data['sn'] == '') {
            $where['sn'] = uniqid();
        } else {
            $where['sn'] = $data['sn'];
        }
        unset($data['sn']);
        $data['update_datetime'] = date("Y-m-d H:i:s");
        $this->mod_db->insert_or_update($where, $data, 'bulletin');
        $this->api_msg->show('200');
    }
    // 列表
    function bulletin_list()
    {
        $datalist = array();
        foreach ($this->db->order_by('update_datetime', 'desc')->get('bulletin')->result_array() as $key => $value) {
            $datalist[$key] = $value;
            $datalist[$key]['html_info'] = nl2br($value['info']);
        }
        $this->api_msg->show('200', '', $datalist);
    }
    // 刪除
    function bulletin_remove()
    {
        $getpost = array('sn');
        $requred = array('sn');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $this->db->where('sn', $data['sn'])->delete('bulletin');
        $this->api_msg->show('200');
    }
    /*******************************
     * 
     * 
     * 分類
     * 
     * 
     */
    function menu_list()
    {
        $main_list = $this->db->order_by('main_sort', 'asc')->get('class_main')->result_array();
        $sub_list = $this->db->order_by('sub_sort', 'asc')->get('class_sub')->result_array();
        $third_list = $this->db->order_by('third_sort', 'asc')->get('class_third')->result_array();

        $datalist = $main_list;
        $i = 0;
        $j = 0;
        $k = 0;

        foreach ($datalist as $k => $v) {
            $datalist[$i]['sublist'] = [];
            foreach ($sub_list as $sk => $sv) {
                if ($v['main_id'] == $sv['main_id']) {
                    $datalist[$i]['sublist'][$j] = $sv;
                    foreach ($third_list as $tk => $tv) {
                        if ($sv['sub_id'] == $tv['sub_id'] && $k < 3) {
                            $datalist[$i]['sublist'][$j]['thirdlist'][$k] = $tv;
                            $k++;
                        }
                    }
                    $j ++;
                    $k = 0;
                }
            }
            $i++;
            $j = 0;
        }
        $this->api_msg->show('200', '', $datalist);
    }


    function class_main_list()
    {
        $data = $this->db->order_by('main_sort', 'asc')->get('class_main')->result_array();
        $this->api_msg->show('200', 'Success', $data);
    }
    function class_main_set()
    {
        $input = array('main_id', 'main_sort', 'main_name', 'main_link');
        $request = array('main_name');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        if ($data['main_link'] == '') {
            $data['main_link'] = '#';
        }
        $where['main_id'] = $data['main_id'];
        $this->mod_db->insert_or_update($where, $data, 'class_main');
        $this->api_msg->show('200');
    }
    function class_main_remove()
    {
        $getpost = array('main_id');
        $requred = array('main_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('main_id' => $data['main_id']);
        $this->mod_apicheck->chk_data($where, 'class_main', '帳號不存在');
        $this->db->where($where)->delete('class_main');
        $this->api_msg->show('200', 'Success');
    }
    // 排序設定
    function class_main_sort()
    {
        $input_data = file_get_contents('php://input');
        $input_data = json_decode($input_data, true);
        foreach ($input_data as $k => $v) {
            $this->db->where('main_id', $v['main_id'])->set(array('main_sort' => $v['main_sort']))->update('class_main');
        }
        $this->api_msg->show('200');
    }

    // 次分類
    function class_sub_list()
    {
        $main_id = $this->input->get_post('main_id');
        if ($main_id != '') {
            $this->db->where(array('main_id' => $main_id));
        }
        $data = $this->db->order_by('sub_sort', 'asc')->get('class_sub')->result_array();
        $this->api_msg->show('200', 'Success', $data);
    }
    function class_sub_set()
    {
        $input = array('sub_id', 'sub_sort', 'main_id', 'sub_name', 'sub_link');
        $request = array('sub_name');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        if ($data['sub_link'] == '') {
            $data['sub_link'] = '#';
        }
        $where['sub_id'] = $data['sub_id'];
        $this->mod_db->insert_or_update($where, $data, 'class_sub');
        $this->api_msg->show('200');
    }
    function class_sub_remove()
    {
        $getpost = array('sub_id');
        $requred = array('sub_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('sub_id' => $data['sub_id']);
        $this->mod_apicheck->chk_data($where, 'class_sub', '帳號不存在');
        $this->db->where($where)->delete('class_sub');
        $this->api_msg->show('200', 'Success');
    }
    // 排序設定
    function class_sub_sort()
    {
        $input_data = file_get_contents('php://input');
        $input_data = json_decode($input_data, true);
        foreach ($input_data as $k => $v) {
            $this->db->where('sub_id', $v['sub_id'])->set(array('sub_sort' => $v['sub_sort']))->update('class_sub');
        }
        $this->api_msg->show('200');
    }

    // 小分類
    function class_third_list()
    {
        $sub_id = $this->input->get_post('sub_id');
        if ($sub_id != '') {
            $this->db->where(array('sub_id' => $sub_id));
        }
        $data = $this->db->order_by('third_sort', 'asc')->get('class_third')->result_array();
        $this->api_msg->show('200', 'Success', $data);
    }
    function class_third_set()
    {
        $input = array('third_id', 'third_sort', 'sub_id', 'third_name', 'third_link');
        $request = array('third_name');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        if ($data['third_link'] == '') {
            $data['third_link'] = '#';
        }
        $where['third_id'] = $data['third_id'];
        $this->mod_db->insert_or_update($where, $data, 'class_third');
        $this->api_msg->show('200');
    }
    function class_third_remove()
    {
        $getpost = array('third_id');
        $requred = array('third_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('third_id' => $data['third_id']);
        $this->mod_apicheck->chk_data($where, 'class_third', '帳號不存在');
        $this->db->where($where)->delete('class_third');
        $this->api_msg->show('200', 'Success');
    }
    // 排序設定
    function class_third_sort()
    {
        $input_data = file_get_contents('php://input');
        $input_data = json_decode($input_data, true);
        foreach ($input_data as $k => $v) {
            $this->db->where('third_id', $v['third_id'])->set(array('third_sort' => $v['third_sort']))->update('class_third');
        }
        $this->api_msg->show('200');
    }
}
