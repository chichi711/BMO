<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
                        
class Period extends CI_Model {
       
    // 取得目前檔期
    function period_now(){
        $where = array(
            'start <='=>date('Y-m-d H:i:s'),
            "end >="=>date('Y-m-d H:i:s')
        );
        $data = $this->db->where($where)->get('period')->row_array();
        $product_ids = explode(',', $data['product_ids']);
        $data['product_list'] = $this->db->where_in('product_id',$product_ids)->get('product')->result_array();
        return $data;
    }
    
    // 執行檔期指令碼
    function do_period_cmd($cmd,$replyToken){
        $this->load->library('linebot');
        $where = array(
            'start <='=>date('Y-m-d H:i:s'),
            "end >="=>date('Y-m-d H:i:s'),
            'cmd'=>$cmd
        );
        if($this->db->where($where)->count_all_results('period') == 0){ 
            return FALSE;
        }else{
            $data = $this->db->where($where)->get('period')->row_array();
            $data['product_list'] = array();
            foreach (explode(',',$data['product_ids']) as $key => $value) {
                # code...
                $data['product_list'][] = $this->db->where('product_id',$value)->get('product')->row_array();
            }
            if(isset($data['product_list'])){
                $products = array();
                foreach ($data['product_list'] as $key => $value) {
                    # code...
                    $products[] = array(
                            "img"=>$value['img_src'],
                            "uri"=>$this->config->item('liff_url').'?target=cart&product_id='.$value['product_id']."&cmd=".$cmd,
                            "subject"=>$value['product_name'],
                            "info"=>$value['sub_info'],
                            "tables"=>array(
                                array("title"=>'原價',"info"=>$value['original_price']),
                                array("title"=>'特價',"info"=>$value['price']),
                            )
                        );
                }
                
                
                $return = $this->linebot->resend_flex($replyToken,$products);
                
                
                return TRUE;
            }else{
                
                $return = $this->linebot->resend_text($replyToken,'目前沒有優惠商品，敬請期待');
                return FALSE;
            }
            
        }
    }
                        
                            
                        
}
                        
/* End of file Period.php */
    
                        