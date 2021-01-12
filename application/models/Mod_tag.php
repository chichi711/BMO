<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_tag extends CI_Model {

    function set_tag($tag,$user_id){
        $data = array(
            'tag' => $tag,
            'user_id' => $user_id,
            'create_datetime'	=> date('Y-m-d H:i:s')
        );
        $this->db->insert('tag_log',$data);
        return true;
    }

    function set_tag_send_log($tag,$qty=1){
        $t = $this->db->where('tag',$tag)->where('ym',date("Y-m"));
        if($t->count_all_results('tag_send_log') == 0){
            $t_data = array(
                'tag'=>$tag,
                'ym'=>date("Y-m"), 
                'qty'=>$qty
            );
            $this->db->insert('tag_send_log',$t_data);
        }else{
            $t_data = $t->get('tag_send_log')->row_array();
        }
    }
                        
                            
                        
}
                        
/* End of file Mod_tag.php */
    
                        