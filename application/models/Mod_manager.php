<?php 
class Mod_manager extends CI_Model {
    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }
    function add_once($data){
        $this->db->insert('manager_main',$data);
        return True;
    }
    function update_once($manager_id,$data){
        $this->db->where('manager_id',$manager_id)->update('manager_main',$data);
    }
    function get_list($where=""){
        if($where != ""){
            $this->db->where($where);
        }
        return $this->db->get('manager_main')->result_array();
        
    }
    // 取得單一資料
    function get_once($manager_id){
        $this->db->where('manager_id',$manager_id);
        return $this->db->get('manager_main')->row_array();
    }
    // 確認帳號存在
    function chk_once($manager_id){
        $this->db->where('manager_id',$manager_id);
        if($this->db->count_all_results('manager_main') == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // 確認可以登入
    function chk_login($manager_id,$manager_pwd){
        $this->db->where('manager_id',$manager_id);
        $this->db->where('manager_pwd',$manager_pwd);
        if($this->db->count_all_results('manager_main') == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // 執行登入動作
    function do_login($manager_id){
        $arr = $this->get_once($manager_id);
        unset($arr['manager_pwd']);
        $arr['login_status'] =  TRUE;
        $this->db->where('manager_id',$manager_id)->update('manager_main',array('last_datetime'=>date("Y-m-d H:i:s")));
        $this->session->set_userdata($arr);
    }
    // 執行登出動作
    function do_logout(){
        $this->session->sess_destroy();
        return TRUE;
    }
    // 確認目前登入狀態
    function chk_login_status($login_page = ''){
        $login_status = $this->session->userdata('login_status');
        // 先判斷有沒有 session
        if($login_status == TRUE){
           return True;
        }
        if($login_page != "login"){
            redirect(base_url('./admin_bmo/login'));
        }
        return FALSE;
        
    }
}
?>