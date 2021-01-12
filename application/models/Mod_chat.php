<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_chat extends CI_Model {
 
    // 確認有沒有聊天室
    function chk_room($user_id) {
        $c = $this->db->where('user_id',$user_id)->count_all_results('chat_room');
        if($c == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // 現存的聊天室列表
    function room_list(){
        return $this->db->order_by('update_datetime','desc')->get('chat_room')->result_array();
    }
    // 聊天內容
    function chat_list($user_id){
        return $this->db->where('user_id',$user_id)->order_by('create_datetime','asc')->get('chat')->result_array();
    }
    // 設定聊天室
    function set_room($user_id,$status){
        $user = $this->linebot->getUserProfile($user_id);
        $data = array(
                        'user_id' => $user_id,
                        'displayName'=>$user['displayName'],
                        'pictureUrl'=>$user['pictureUrl'],
                        'status' => $status,
                        'update_datetime'=> date('Y-m-d H:i:s')
                    );

        switch ($status) {
            case 'new': // 設定聊天室有新消息
                $data['status'] = 'new';
                if($this->chk_room($user_id)){
                    unset($data['user_id']);
                    $this->db->where('user_id', $user_id)->update('chat_room',$data);
                }else{
                    $this->db->insert('chat_room',$data);
                }
                
                return true;
                # code...
                break;
            case 'off': // 關閉聊天室
                # code...
                $this->db->where('user_id',$user_id)->delete('chat_room');
                return true;
                break;
            case 'read': // 設定聊天室已讀
                unset($data['user_id']);
                $data['status'] = 'read';
                $this->db->where('user_id',$user_id)->update('chat_room',$data);
                return true;
                break;
            default:
                # code...
                return false;
                break;
        }
    }
    
                        
                            
                        
}
                        
/* End of file Mod_chat.php */
    
                        