<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_user extends CI_Model {
                        
    function chk_once($user_id,$res_data = false){
        $this->db->where('user_id',$user_id);
        if($this->db->count_all_results('user') == 0){
            return false;
        }else{
            if($res_data == false){
                return true;
            }else{
                return $this->get_once($user_id);
            }
        }
    }       
    function get_once($user_id){
        $this->db->where('user_id',$user_id);
        return $this->db->get('user')->row_array();
    }      
    function set($data){
        $data['update_datetime'] = date('Y-m-d H:i:s');
        if($this->chk_once($data['user_id']) == false){
            $data['create_datetime'] = date('Y-m-d H:i:s');
            $this->db->insert('user', $data);
        }else{
            $this->db->where('user_id',$data['user_id']);
            unset($data['user_id']);
            $this->db->update('user', $data);
        }
        return true;
    }     
    function reset_point($user_id){
        $point = $this->mod_ufs->get_point($user_id);
        // 回寫 point 到主表
        if(isset($point['point']['total'])){
            $point_total = $point['point']['total'];
            $this->db->where('user_id',$user_id)->update('user',array('point'=>$point_total));
        }
    }
                                             
        // 確認可以登入
        function chk_login($user_id,$user_pwd){
            $this->db->where('user_id',$user_id);
            $this->db->where('user_pwd',$user_pwd);
            if($this->db->count_all_results('user') == 0){
                return FALSE;
            }else{
                return TRUE;
            }
        }
        // 執行登入動作
        function do_login($user_id){
            $arr = $this->get_once($user_id);
            unset($arr['user_pwd']);
            $arr['login_status'] =  TRUE;
            $this->db->where('user_id',$user_id)->update('user',array('last_datetime'=>date("Y-m-d H:i:s")));
            $this->session->set_userdata($arr);
        }
        // 執行登出動作
        function do_logout(){
            $this->session->unset_userdata('login_status');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('cart');
            return TRUE;
        }
        // 確認目前登入狀態
        function chk_login_status(){
            $login_status = $this->session->userdata('login_status');
            if($login_status == TRUE){
               return True;
            } else{
                return FALSE;
            }
            
        }     
        // 確認目前登入狀態
        function get_login_val($login_page = ''){
            $login_status = $this->session->userdata('login_status');
            $user_id = $this->session->userdata('user_id');
            // 先判斷有沒有 session
            if($login_status == TRUE){
               return $user_id;
            }
            if($login_page != "login"){
                // redirect(base_url('./login'));
                return FALSE;
            }
            
        }     
                        
}
                        
/* End of file Mod_user.php */
    
                        