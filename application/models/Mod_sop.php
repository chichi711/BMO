<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_sop extends CI_Model {
                        
    function chk_once($sop_id,$res_data = false){
        $this->db->where('sop_id',$sop_id);
        if($this->db->count_all_results('sop_main') == 0){
            return false;
        }else{
            if($res_data == false){
                return true;
            }else{
                return $this->get_once($sop_id);
            }
        }
    }       
    function get_once($sop_id){
        $this->db->where('sop_id',$sop_id);
        return $this->db->get('sop_main')->row_array();
    }      
    function set($data){
        $data['update_datetime'] = date('Y-m-d H:i:s');
        if($this->chk_once($data['sop_id']) == false){
            $data['create_datetime'] = date('Y-m-d H:i:s');
            $this->db->insert('sop_main', $data);
        }else{
            $this->db->where('sop_id',$data['sop_id']);
            unset($data['sop_id']);
            $this->db->update('sop_main', $data);
        }
        return true;
    }     
                            
                        
}
                        
/* End of file Mod_sop.php */
    
                        