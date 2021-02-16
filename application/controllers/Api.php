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
        foreach ($data as $k => &$v) {
            unset($v['manager_pwd']);
        }
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
        $menu_list = $this->config->item('menu');
        $main_list = $this->db->order_by('main_sort', 'asc')->get('class_main')->result_array();
        $sub_list = $this->db->order_by('sub_sort', 'asc')->get('class_sub')->result_array();

        $datalist = $menu_list;
        $i = 0;
        $j = 0;
        $k = 0;

        foreach ($datalist as $menu_k => $menu_v) {
            $datalist[$i]['mainlist'] = [];
            foreach ($main_list as $main_k => $main_v) {
                if ($menu_v['menu_id'] == $main_v['menu_id']) {
                    $datalist[$i]['mainlist'][$j] = $main_v;
                    foreach ($sub_list as $sub_k => $sub_v) {
                        if ($main_v['main_id'] == $sub_v['main_id'] && $k < 2) {
                            $datalist[$i]['mainlist'][$j]['sublist'][$k] = $sub_v;
                            $k++;
                        }
                    }
                    $j++;
                    $k = 0;
                }
            }
            $i++;
            $j = 0;
        }
        $this->api_msg->show('200', '', $datalist);
    }

    function menu_class_list()
    {
        $data = $this->config->item('menu');
        $this->api_msg->show('200', 'Success', $data);
    }

    // 次分類
    function class_main_list()
    {
        $menu_id = $this->input->get_post('menu_id');
        if ($menu_id != '') {
            $this->db->where(array('menu_id' => $menu_id));
        }
        $data = $this->db->order_by('main_sort', 'asc')->get('class_main')->result_array();
        $this->api_msg->show('200', 'Success', $data);
    }
    function class_main_set()
    {
        $input = array('main_id', 'main_sort', 'menu_id', 'main_name');
        $request = array('main_name');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);

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
        $this->mod_apicheck->chk_data($where, 'class_main', '類別不存在');
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

    // 小分類
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
        $input = array('sub_id', 'sub_sort', 'main_id', 'sub_name');
        $request = array('sub_name');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
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
        $this->mod_apicheck->chk_data($where, 'class_sub', '類別不存在');
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
    // 取得所有分類名稱
    function get_all_class_name()
    {
        $getpost = array('menu_id', 'main_id', 'sub_id');
        $requred = array('menu_id', 'main_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);

        $menu = $this->config->item('menu');
        foreach ($menu as $k => $v) {
            if ($data['menu_id'] == $v['menu_id']) {
                $data['menu_name'] = $v['menu_name'];
            }
        }
        $data['main_name'] = $this->db->where(array('main_id' => $data['main_id']))->get('class_main')->result_array()[0]['main_name'];
        if ($data['sub_id'] != '') {
            $data['sub_name'] = $this->db->where(array('sub_id' => $data['sub_id']))->get('class_sub')->result_array()[0]['sub_name'];
        } else {
            $data['sub_name'] = '';
        }

        $this->api_msg->show('200', 'Success', $data);
    }
    /*******************************
     * 
     * 商品
     * 
     * author : 作者
     * publisher : 出版社
     * publication_date : 出版日期
     */
    function product_status_configs()
    {
        $data = $this->config->item('product_status');
        $this->api_msg->show('200', 'Success', $data);
    }

    function product_list()
    {
        $input = array('menu_id', 'main_id', 'sub_id','now_page');
        $request = array('menu_id');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);

        $this->db->where(array('menu_id' => $data['menu_id']));
        if ($data['main_id'] != '') {
            $this->db->where(array('main_id' => $data['main_id']));
        }
        if ($data['sub_id'] != '') {
            $this->db->where(array('sub_id' => $data['sub_id']));
        }

        $init_data = $this->db->get('product')->result_array();

        $datalist = [];
        foreach ($init_data as $k => $v) {
            $datalist[$k] = $v;
            $datalist[$k]['main_name'] = $this->db->where(array('main_id' => $v['main_id']))->get('class_main')->result_array()[0]['main_name'];
            $datalist[$k]['sub_name'] = $this->db->where(array('sub_id' => $v['sub_id']))->get('class_sub')->result_array()[0]['sub_name'];
            $datalist[$k]['status'] = $this->config->item('product_status')[$v['status']];
            $datalist[$k]['slide_imgs'] = explode(",", $v['slide_imgs'])[0];
        }
        // 分頁功能開始
        if (!isset($data['now_page'])) {
            $now_page = 1;
        } else {
            $now_page = $data['now_page'];
        }
        $data = $this->page->pages_data($datalist, 9, $now_page);
        //分頁功能結束
        $this->api_msg->show('200', 'Success', $data);
    }
    function product_info()
    {
        $input = array('product_id');
        $request = array('product_id');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $data = $this->db->where($data)->get('product')->result_array()[0];

        $menu = $this->config->item('menu');
        foreach ($menu as $k => $v) {
            if ($data['menu_id'] == $v['menu_id']) {
                $data['menu_name'] = $v['menu_name'];
            }
        }
        $data['main_name'] = $this->db->where(array('main_id' => $data['main_id']))->get('class_main')->result_array()[0]['main_name'];
        $data['sub_name'] = $this->db->where(array('sub_id' => $data['sub_id']))->get('class_sub')->result_array()[0]['sub_name'];
        // 將字串變回array
        if ($data['slide_imgs']) {
            $data['slide_imgs'] = explode(",", $data['slide_imgs']);
        }

        $this->api_msg->show('200', 'Success', $data);
    }

    function product_set()
    {
        $input = array('product_id', 'product_name', 'main_img', 'slide_imgs', 'price', 'author', 'publisher', 'publication_date', 'language', 'stock', 'info', 'about_author', 'catalog', 'menu_id', 'main_id', 'sub_id', 'status', 'tag');
        $request = array('product_id', 'product_name', 'main_img', 'price', 'author', 'publisher', 'publication_date', 'language', 'menu_id', 'main_id', 'sub_id', 'status');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $where['product_id'] = $data['product_id'];

        // 將array用,區隔變成字串
        if ($data['slide_imgs']) {
            $lastItems = count($data['slide_imgs']);
            $i = 0;
            $ans = '';
            foreach ($data['slide_imgs'] as $k => $v) {
                // 最後一項不用加逗號
                if (++$i === $lastItems) {
                    $ans .= $v;
                } else {
                    $ans .= $v . ',';
                }
            }
            $data['slide_imgs'] = $ans;
        }

        $this->mod_db->insert_or_update($where, $data, 'product');
        $this->api_msg->show('200');
    }

    function product_chg_status()
    {
        $input = array('product_id', 'status');
        $request = array('product_id', 'status');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $where['product_id'] = $data['product_id'];
        unset($data['product_id']);
        $this->mod_db->where($where)->set($data)->update('product');
        $this->api_msg->show('200');
    }

    function product_remove()
    {
        $getpost = array('product_id');
        $requred = array('product_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('product_id' => $data['product_id']);
        $this->mod_apicheck->chk_data($where, 'product', '商品不存在');
        $this->db->where($where)->delete('product');
        $this->api_msg->show('200', 'Success');
    }
    function product_img_upload()
    {
        // echo exec('whoami');
        $file_name =  uniqid() . '.jpg';
        $output_file = "./upload/product/" . $file_name;
        copy($_FILES['img']['tmp_name'], $output_file);
        $url = "/upload/product/" . $file_name;
        // echo  $output_file;
        $this->api_msg->show('200', 'Success', $url);
    }

    /******************************
     * 
     * 
     * 編輯器上傳照片
     * 
     * 
     */
    function summernote_upload()
    {
        $file_name = "summernote_" . uniqid() . '.jpg';
        if (!is_dir('./upload')) {
            mkdir('./upload', 0755, true);
        }
        if (!is_dir('./upload/summernote')) {
            mkdir('./upload/summernote', 0755, true);
        }
        $output_file = "./upload/summernote/" . $file_name;
        copy($_FILES['img']['tmp_name'], $output_file);
        echo  $output_file;
    }

    /*******************************
     * 
     * 會員
     * 
     */

    function user_add()
    {
        $input = array('user_id', 'email', 'user_pwd');
        $request = array('user_id', 'email', 'user_pwd');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $where['user_id'] = $data['user_id'];

        $this->mod_apicheck->chk_repeat($where, 'user', '帳號重複');
        $this->db->insert('user', $data);
        $this->api_msg->show('200');
    }
    function user_login()
    {
        $getpost = array('user_id', 'user_pwd');
        $requred = array('user_id', 'user_pwd');
        $data = $this->getpost->get_post_json($getpost, $requred);

        // 如果session有購物車資料的話，存進資料庫
        if ($this->session->userdata('cart')) {
            $cart = $this->session->userdata('cart');
            foreach ($cart as $key => $val) {
                $where = array('user_id' => $data['user_id'], 'product_id' => $val['product_id']);

                $this->mod_cart->insert_or_update($where, $val, 'cart');
            }
            $this->session->unset_userdata('cart');
        }

        if ($this->mod_user->chk_login($data['user_id'], $data['user_pwd'])) {
            $this->mod_user->do_login($data['user_id']);
            $json_arr['session'] = $this->session->all_userdata();
            $this->api_msg->show('200', 'success', $json_arr);
        } else {
            $this->api_msg->show('500', 'Login Failed');
        }
    }
    function user_remove()
    {
        $getpost = array('user_id');
        $requred = array('user_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('user_id' => $data['user_id']);
        $this->mod_apicheck->chk_data($where, 'user', '會員不存在');
        $this->db->where($where)->delete('user');
        $this->api_msg->show('200', 'Success');
    }
    function chk_login()
    {
        $data = $this->mod_user->get_login_val();
        $this->api_msg->show('200', 'Success', $data);
    }

    /*******************************
     * 
     * 購物車
     * 
     */
    function cart_add()
    {
        $input = array('product_id', 'qty');
        $request = array('product_id', 'qty');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        if ($this->mod_user->chk_login_status()) {
            $data['user_id'] = $this->mod_user->get_login_val();
            $where = array('user_id' => $data['user_id'], 'product_id' => $data['product_id']);
            $this->mod_cart->insert_or_update($where, $data, 'cart');
        } else {
            $this->mod_cart->set_2arr_cart($data, $data['product_id'], $data['qty']);
        }
        $this->api_msg->show('200');
    }

    function cart_edit()
    {
        $request = array('sn', 'qty');
        $requred = array('sn', 'qty');
        $init_data = $this->getpost->array2d_json_format($request,$requred);
        if($init_data == false){
            $json_arr['requred_data'] = $requred;
            $json_arr['request_data'] = $request;
            $json_arr['requred'] = $this->getpost->array2d_array_error($request,$requred);
            $this->api->show('000','',$json_arr);
        }
        foreach($init_data as  $key => $val){
            $this->db->where(array('sn' => $val['sn']))->set(array('qty' => $val['qty']))->update('cart');
        }
        $this->api_msg->show('200');
    }

    function cart_remove()
    {
        $getpost = array('sn');
        $requred = array('sn');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('sn' => $data['sn']);
        $this->mod_apicheck->chk_data($where, 'cart', '資料不存在');
        $this->db->where($where)->delete('cart');
        $this->api_msg->show('200', 'Success');
    }

    function user_cart_remove()
    {
        $getpost = array('user_id');
        $requred = array('user_id');
        $data = $this->mod_apicheck->chk_get_post_requred($getpost, $requred);
        $where = array('user_id' => $data['user_id']);
        $this->db->where($where)->delete('cart');
        $this->api_msg->show('200', 'Success');
    }

    function cart_list()
    {
        $input = array('user_id');
        $request = array('user_id');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $this->db->where(array('user_id' => $data['user_id']));
        $data = $this->db->order_by('sn','desc')->get('cart')->result_array();

        if($data){
            $total_amount = 0;
            foreach($data as $key => &$val) {
                $product = $this->db->where(array('product_id' => $val['product_id']))->get('product')->result_array()[0];
                $val['product_name'] = $product['product_name'];
                $val['main_img'] = $product['main_img'];
                $val['price'] = $product['price'];
                $val['sub_total'] = $product['price'] * $val['qty'];
                $total_amount += $val['sub_total'];
            }
            $datalist['datalist'] = $data;
            $datalist['total_amount'] = $total_amount;
            $this->api_msg->show('200', 'Success', $datalist);
        } else {
            $this->api_msg->show('204', 'No Data');
        }
    }

    function session_cart_list()
    {
        $data = $this->session->userdata('cart');
        if($data){
            foreach($data as $key => &$val) {
                $product = $this->db->where(array('product_id' => $val['product_id']))->get('product')->result_array()[0];
                $val['product_name'] = $product['product_name'];
                $val['main_img'] = $product['main_img'];
                $val['price'] = $product['price'];
            }
            $this->api_msg->show('200', 'Success', $data);
        }else{
            $this->api_msg->show('204', 'No Data');
        }
    }
    /*******************************
     * 
     * 訂單
     * 
     * payment 付款方式
     * freight 運費
     * freight_com 物流名稱
     * total_amount 總金額
     * 
     */
    function order_main_add()
    {
        $input = array('order_id', 'user_id', 'receive_name', 'receive_mobile', 'receive_addr', 'payment', 'freight', 'total_amount', 'freight_com');
        $request = array('order_id', 'user_id', 'receive_name', 'receive_mobile', 'receive_addr', 'payment', 'freight', 'total_amount', 'freight_com');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);

        $data['order_status'] = 0;
        $data['creat_datetime'] = date('Y-m-d H:i:s');
        $data['update_datetime'] = date('Y-m-d H:i:s');

        $this->db->insert('order_main', $data);
        $this->api_msg->show('200');
    }
    function order_main_edit()
    {
        $input = array('order_id','order_status', 'user_id', 'receive_name', 'receive_mobile', 'receive_addr', 'payment', 'freight', 'total_amount', 'freight_com');
        $request = array('order_id','order_status', 'user_id', 'receive_name', 'receive_mobile', 'receive_addr', 'payment', 'freight', 'total_amount', 'freight_com');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);

        $this->db->where(array('order_id' => $data['order_id']))->set($data)->update('order_main');
        $this->api_msg->show('200');
    }

    function order_sub_add()
    {
        $request = array('order_id','product_id', 'product_name', 'main_img', 'price', 'qty', 'sub_total');
        $requred = array('product_id', 'product_name', 'main_img', 'price', 'qty', 'sub_total');
        $init_data = $this->getpost->array2d_json_format($request,$requred);
        if($init_data == false){
            $json_arr['requred_data'] = $requred;
            $json_arr['request_data'] = $request;
            $json_arr['requred'] = $this->getpost->array2d_array_error($request,$requred);
            $this->api_msg->show('000','',$json_arr);
        }
        foreach($init_data as  $key => $val){
            $val['order_id'] = $init_data[0]['order_id'];
            $this->db->insert('order_sub', $val);
        }
        $this->api_msg->show('200');
    }
    function order_sub_edit()
    {
        // $request = array('order_id','product_id', 'product_name', 'main_img', 'price', 'qty', 'sub_total');
        // $requred = array('order_id','product_id', 'product_name', 'main_img', 'price', 'qty', 'sub_total');
        // $init_data = $this->getpost->array2d_json_format($request,$requred);
        // if($init_data == false){
        //     $json_arr['requred_data'] = $requred;
        //     $json_arr['request_data'] = $request;
        //     $json_arr['requred'] = $this->getpost->array2d_array_error($request,$requred);
        //     $this->api->show('000','',$json_arr);
        // }
        // $where = array('order_id' => $init_data[0]['order_id']);
        // $this->db->where($where)->delete('order_sub');
        // foreach($init_data as  $key => $val){
        //     $this->db->insert('order_sub', $val);
        // }
        // $this->api_msg->show('200');
    }

    function order_list()
    {
        $input = array('now_page');
        $request = array();
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $init_data = $this->db->order_by('update_datetime','desc')->get('order_main')->result_array();
        foreach($init_data as  $key => &$val){
            $val['order_status_name'] = $this->config->item('order_status')[$val['order_status']];
        }
        // 分頁功能開始
        if (!isset($data['now_page'])) {
            $now_page = 1;
        } else {
            $now_page = $data['now_page'];
        }
        $datalist = $this->page->pages_data($init_data, 9, $now_page);
        //分頁功能結束
        $this->api_msg->show('200', 'Success', $datalist);
    }

    function order_info()
    {
        $input = array('order_id');
        $request = array('order_id');
        $data = $this->mod_apicheck->chk_get_post_requred($input, $request);
        $datalist['main'] = $this->db->where($data)->get('order_main')->result_array()[0];
        $datalist['sub'] = $this->db->where($data)->get('order_sub')->result_array();


        $this->api_msg->show('200', 'Success', $datalist);
    }

    /*******************************
     * 
     * 圖表
     * 
     */
    // TODO

    /*******************************
     * 
     * 訊息
     * 
     */
    // TODO

    /*******************************
     * 
     * 標籤
     * 
     */
    // TODO

    /*******************************
     * 
     * 折扣
     * 
     */
    // TODO
}
