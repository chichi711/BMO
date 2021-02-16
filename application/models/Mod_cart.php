<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_cart extends CI_Model {
                        
    function set_2arr_cart($data, $product_id, $qty = 1){
        // 存二維陣列進session
        if($this->session->userdata('cart')){
            $cart = $this->session->userdata('cart');
            $count = count($cart);
            $have = false;
            // 如果已經有一樣的商品，則增加數量
            foreach($cart as $key => &$val){
                if($val['product_id'] == $product_id){
                    $val['qty'] += $qty;
                    $have = true;
                }
            }
            // 如果沒有一樣的商品則新增
            if(!$have){
                $cart[$count] = $data; 
            }
            $this->session->set_userdata('cart',$cart);
        }else{
            // 如果session內沒有cart資料
            $datalist[0] = $data;
            $this->session->set_userdata('cart',$datalist);
        }
    }       

    /**
     * 自動判斷要更新或是新增
     */
    function insert_or_update($where,$set,$table){
        foreach ($set as $key => $value) {
            # code...
            if(in_array($key,$where)){
                unset($set[$key]);
            }
        }
        if($this->db->where($where)->count_all_results($table) == 0){
            $set = array_merge($where,$set);
            $this->db->insert($table,$set);
        }else{
            $cart = $this->db->where($where)->get('cart')->result_array()[0];
            $set['qty'] += $cart['qty'];
            $this->db->update($table,$set,$where);
        }

    }
  
}
                        
/* End of file Mod_cart.php */
    
                        