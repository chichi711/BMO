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
                                             
                            
                        
}
                        
/* End of file Mod_user.php */
    
                        