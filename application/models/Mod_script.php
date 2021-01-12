<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Mod_script extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->model('mod_tag');
        $this->load->model('mod_ufs');
    }

    function get_script($script_id) {
        $data = $this->db->where('script_id',$script_id)->get('gift_point_script')->row_array();
        if($data['switch'] == 0){
            return false;
        }else{
            return $data;
        }
    }
    function ch_point($user_id,$act,$point,$note){
        $data = array(
            'point'=>$point,
            'act'=>$act,
            'note'=>$note
        );
        $res = json_decode($this->mod_ufs->ch_point($user_id,$data),true);
        if($res['sys_code'] == "200"){
            return true;
        }else{
            return false;
        }

    }

   
    /********************************
     * 
     *   序號回填選擇配點
     */
    function channel_sn_mapping($user_id,$point,$channel_id,$class_id,$product_id){
        $point_fun_arr['first_m_mapping'] = $this->first_m_mapping($user_id,$point);
        $point_fun_arr['birthday_mapping'] = $this->birthday_mapping($user_id,$point);
        $act = $this->act_script_check($user_id,$point,$channel_id,$class_id,$product_id);
        $point_fun_arr['act_script_check'] = $act['point'];
        $new = $point;
        // 找尋最好的贈點數
        foreach ($point_fun_arr as $key => $value) {
            # code...
            if($value > $new){
                $function = $key;
                $new = $value;
            }
        }
        if($new == $point){ // 如果沒有觸發到任何活動
            //TODO （也許需要解決）預設沒有加入特殊活動時的贈點不會有判斷直接發送
            $note = '商品序號回填贈點 '.$point;
            $this->ch_point($user_id,'add',$point,'商品序號回填贈點 '.$point);
            
            $this->mod_ufs->send_single_msg($user_id,$note);
            
            $this->load->model('mod_tag');
            $this->mod_tag->set_tag_send_log('商品序號回填贈點');

        }else{
            switch ($function) {
                case 'first_m_mapping':
                    $this->first_m_mapping($user_id,$point,true);
                    # code...
                    break;
                case 'birthday_mapping':
                    $this->birthday_mapping($user_id,$point,true);
                    # code...
                    break;
                case 'act_script_check':
                    $this->do_act_script($act['act_script_id'],$user_id,$new,$act['note']);
                    break;
            }
        }
        
        return $new;
    }
    function do_act_script($act_script_id,$user_id,$point,$note){
        $this->ch_point($user_id,'add',$point,$note);
        // 設定需要送出的 tags
        $act_script = $this->db->where('act_script_id',$act_script_id)->get('act_script')->row_array();
        $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
        $t_arr_str = $act_script['tags'];
        if($t_arr_str != ""){
            foreach(explode(',',$t_arr_str) as $key => $value){
                $this->mod_ufs->set_tag_main($value);
                $this->mod_ufs->set_user_tag($user_id,$value);
            }
        }
        //TODO 參加活動訊息通知
        if($act_script['msg_switch'] == '1' AND $act_script['msg_text'] != NULL){
            $note = $act_script['msg_text'];
            $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
            $note = str_replace('{{name}}',$user['name'],$note);
            $note = str_replace('{{point}}',$user['point'],$note);
            $this->mod_ufs->send_single_msg($user_id,$note);
            $this->load->model('mod_tag');
            $this->mod_tag->set_tag_send_log('商品序號回填贈點');
        }
    }

    //檢查指定活動贈點
    function act_script_check($user_id,$point,$channel_id,$class_id,$product_id){
        $this->db->where('switch',1);
        $this->db->where('start <=',date('Y-m-d H:i:s'));
        $this->db->where('end >=',date('Y-m-d H:i:s'));
        $all_act = $this->db->get('act_script')->result_array();
        // echo $this->db->last_query();
        // 尋找符合條件的
        $res = array(
            'point'=>$point,
            'note'=>'商品贈點',
            'act_script_id'=>''
        );
        $new_point = $point;
        
        foreach($all_act as $k=>$v){
            
            if( !in_array($channel_id,explode(',',$v['channel_id']))){
                unset($all_act[$k]);
            }else{
                if(!in_array($class_id,explode(',',$v['class_id']))){
                    unset($all_act[$k]);
                }else{
                    
                    if( !in_array($product_id,explode(',',$v['product_id']))){
                        unset($all_act[$k]);
                    }else{
                        //如果所有條件都符合
                        // 計算新點數
                        if($v['multiple'] == 0){
                            $new_point = $point + $v['point'];
                        }else{
                            $new_point = $point * $v['multiple'];
                        }
                        // 如果比上一條規則更好就複寫
                        if($new_point > $res['point']){
                            $res = array(
                                'point'=>$new_point,
                                'note'=>$v['act_script_name'],
                                'act_script_id'=>$v['act_script_id']
                            );
                        }// end if new_point
                        
                    }// endif product
                } // end if class
            } // end if channel
        } // end foreach
        // print_r($res);
        return $res;
       
        
    }

    // 首登所有產品序號贈點
    function first_m_mapping($user_id,$point,$do=false){
        // 先確定符合資格，在這個月 1號前不可以有資料
        if($this->db->where('user_id',$user_id)->where('mapping_datetime <=',date('Y-m').'-01 00:00')->count_all_results('sn') == 0){
            $data = $this->get_script('first_m_mapping');
            if($data != false){
                if($data['multiple'] == 0){
                    $point = $point + $data['point'];
                }else{
                    $point = $point * $data['multiple'];
                }
                $note = $data['script_name'].' '.$point;
            }else{
                $note = '商品序號回填贈點 '.$point;
            }
        }
        
        if($do==true){
            $this->ch_point($user_id,'add',$point,$note);
            //TODO 首登所有產品序號贈點
            if($data['msg_switch'] == "1" AND $data['msg_text'] != NULL){
                $note = $data['msg_text'];
                $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
                $note = str_replace('{{name}}',$user['name'],$note);
                $note = str_replace('{{point}}',$user['point'],$note);
                $this->mod_ufs->send_single_msg($user_id,$note);
                $this->load->model('mod_tag');
                $this->mod_tag->set_tag_send_log('商品序號回填贈點');
            }
            
            
        }
        
        return $point;
    }
    function birthday_mapping($user_id,$point,$do=false){
        $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
        // 先確定符合資格
        if($user['birth_month'] == date('n')){
            $data = $this->get_script('birthday_mapping');
            if($data != false){
                if($data['multiple'] == 0){
                    $point = $point + $data['point'];
                }else{
                    $point = $point * $data['multiple'];
                }
                $note = $data['script_name'].' '.$point;
            }else{
                $note = '商品序號回填贈點 '.$point;
            }
        }
        if($do==true){
            $this->ch_point($user_id,'add',$point,$note);
            //TODO birthday_mapping
            if($data['msg_switch'] == "1" AND $data['msg_text'] != NULL){
                $note = $data['msg_text'];
                $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
                $note = str_replace('[name]',$user['name'],$note);
                $note = str_replace('{{point}}',$user['point'],$note);
                $this->mod_ufs->send_single_msg($user_id,$note);
                $this->load->model('mod_tag');
                $this->mod_tag->set_tag_send_log('生日當月加成');
            }
        }
        return $point;
    }
    








    // 邀請好友紅利
    function invite_user($user_id){
        $data = $this->get_script('invite_user');
        if($data != false){
            

            $this->ch_point($user_id,'add',$data['point'],$data['script_name'].' '.$data['point']);
            //TODO 邀請好友紅利
            if($data['msg_switch'] == "1" AND $data['msg_text'] != NULL){
                $note = $data['msg_text'];
                $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
                $note = str_replace('[name]',$user['name'],$note);
                $note = str_replace('{{point}}',$user['point'],$note);
                $this->mod_ufs->send_single_msg($user_id,$note);
                $this->load->model('mod_tag');
                $this->mod_tag->set_tag_send_log('邀請好友紅利');
            }
            return true;
        }else{
            return false;
        }
    }
    // 加入會員贈點
    function reg_user($user_id){
        $data = $this->get_script('reg_user');
        if($data != false){
            $this->ch_point($user_id,'add',$data['point'],$data['script_name'].' '.$data['point']);
            //TODO 加入會員贈點
            if($data['msg_switch'] == "1" AND $data['msg_text'] != NULL){
                $note = $data['msg_text'];
                $user = $this->db->where('user_id',$user_id)->get('user')->row_array();
                $note = str_replace('[name]',$user['name'],$note);
                $note = str_replace('{{point}}',$user['point'],$note);
                $this->mod_ufs->send_single_msg($user_id,$note);
                $this->load->model('mod_tag');
                $this->mod_tag->set_tag_send_log('加入會員贈點');
            }
            return true;
        }else{
            return false;
        }
    }

                        
}
                        
/* End of file Mod_script.php */
    
                        