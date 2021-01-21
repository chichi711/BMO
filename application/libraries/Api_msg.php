<?php 
class Api_msg{
    function show($sys_code,$sys_msg='',$data=''){
        if($sys_msg == '' ){
            switch ($sys_code) {
                case '000':
                    # code...
                    $sys_msg = 'Data input error';
                    break;
                case '200':
                    # code...
                    $sys_msg = 'Success';
                    break;
                case '500':
                    $sys_msg = 'Error';
                    break;
                case '501':
                    $sys_msg = 'Duplicate Data';
                    break;
                case '404':
                    $sys_msg = 'Data Not Found';
                    break;
                default:
                    # code...
                    $sys_msg = "Other Msg";
                    break;
            }
        }
        if($data != ""){
            if(isset($data['datalist'])){
                $json_arr = $data;
            }else{
                $json_arr['data'] = $data;
            }
            
        }
        $json_arr['sys_msg'] = $sys_msg;
        
        $json_arr['sys_code'] = $sys_code;
        echo json_encode($json_arr);
        exit();
    }
}
?>