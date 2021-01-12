<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_ufs extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->library('curl');
    }

    function channel_id(){
        return $channel_id = $this->config->item('channel_id');
    }

    /*******
     * 
     * 
     *  標籤
     * 
     */
    // 標籤
    function set_tag_main($tag){
        $data = array(
            'channel_id'=>$this->channel_id(),
            "tag"=>$tag,
            'tag_desc'=>$tag
        );
        $api = $this->config->item("ufs_link")."api/v0/set_tag_main";
        return $this->curl->sample($api,'POST',$data);
    }
    function set_user_tag($user_id,$tag){
        // 先設定 tag
        $t = json_decode($this->set_tag_main($tag),true);
        $data = array(
            'channel_id'=>$this->channel_id(),
            "tag"=>$tag,
            'user_id'=>$user_id
        );
        $api = $this->config->item("ufs_link")."api/v1/set_user_tag";
        return $this->curl->sample($api,'POST',$data);
    }
    function get_tag_list(){
        $api = $this->config->item("ufs_link")."api/v0/get_tag_list/".$this->channel_id();
        return $this->curl->sample($api);
    }
    // 取得單一 tag 追蹤用戶數
    function get_tag_qty($tag){
        $api = $this->config->item("ufs_link")."api/v0/get_tag_qty/".$this->channel_id().'/'.$tag;
        $data =  $this->curl->sample($api);
        $res = json_decode($data,true);
        return $res['qty'];
    }


    /*********
     * 使用者
     */
    function set_user($user_id){
        $api = $this->config->item("ufs_link")."api/v1/set_user/".$this->channel_id()."/".$user_id;
        return $this->curl->sample($api);
    }
    function remove_user($user_id){
        $api = $this->config->item("ufs_link")."api/v0/remove_user/".$this->channel_id()."/".$user_id;
        return $this->curl->sample($api);
    }
    // 重設手機驗證
    function reset_mobile_chk($user_id){
        $api = $this->config->item("ufs_link")."api/v1/reset_mobile_chk/".$this->channel_id()."/".$user_id;
        return $this->curl->sample($api);
    }
    function get_point($user_id){
        $api = $this->config->item("ufs_link")."api/v1/user_point/".$this->channel_id()."/".$user_id;
        return $this->curl->sample($api);
    }
    function send_mobile_chk($user_id,$mobile){
        $api = $this->config->item("ufs_link")."api/v0/send_mobile_chk/".$this->channel_id()."/".$user_id.'/'.$mobile;
        return $this->curl->sample($api);
    }
    // /api/v0/chk_mobile_code/<channel_id>/<user_id>/<mobile_code>
    function chk_mobile_code($user_id,$mobile_code){
        $api = $this->config->item("ufs_link")."api/v0/chk_mobile_code/".$this->channel_id()."/".$user_id.'/'.$mobile_code;
        return $this->curl->sample($api);
    }
    

    /**
     * $data = array('point','act','note');
     * 
     * 
     */
    function ch_point($user_id,$data){
        $api = $this->config->item("ufs_link")."api/v1/ch_point/".$this->channel_id()."/".$user_id;
        $res = $this->curl->sample($api,'POST',$data);
        $res_arr = json_decode($res,true);
        if(isset($res_arr['data']['total'])){
            $this->db->where('user_id',$user_id)->update('user',array('point'=>$res_arr['data']['total']));
        }
        return $res;
    }
    // '/api/v1/log_point/<channel_id>/<user_id>'
    function log_point($user_id,$act){
        $api = $this->config->item("ufs_link")."api/v1/log_point/".$this->channel_id()."/".$user_id.'/'.$act;
        return $this->curl->sample($api);
    }
    // /api/v1/set_product/<channel_id>
    function gift_set($data){
        $api = $this->config->item("ufs_link")."api/v1/set_product/".$this->channel_id();
        return $this->curl->sample($api,'POST',$data);
    }


    /*******
     * 發送訊息
     */
    function send_single_msg($user_id,$msg){
        $api = $this->config->item("ufs_link")."api/v1/send_single_msg/".$this->channel_id().'/'.$user_id;
        $data=array(
            'message'=>$msg
        );
        return $this->curl->sample($api,'POST',$data);
    }
    function send_tag_msg($tag,$message){
        $api = $this->config->item("ufs_link")."api/v1/send_multicast_msg_by_tag";
        $data=array(
            "channel_id"=>$this->channel_id(),
            'message'=>$message,
            "tag"=>$tag
        );
        return $this->curl->sample($api,'POST',$data);
    }
}
                        
/* End of file Mod_ufs.php */