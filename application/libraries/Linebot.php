<?php
class Linebot{
    // private $channelAccessToken;
    // private $channelSecret;

    public function __construct($config)
    {
        $this->CI =& get_instance();
		$this->CI->load->config('linebot');
        $this->channelAccessToken = $this->CI->config->item('linebot')['channelAccessToken'];
        $this->channelSecret = $this->CI->config->item('linebot')['channelSecret'];
    }
    


    function send_text($user_id,$text){
        $payload = array(
            "to"=>array($user_id),
            "messages"=>[$this->text_format($text)]
        );
        return $this->send($payload,'send');
    }
    function send_image($user_id,$src){
        $payload = array(
            "to"=>array($user_id),
            "messages"=>[$this->img_format($src)]
        );
        return $this->send($payload,'send');
    }


    function resend_text($replyToken,$text){
        $payload = array(
            "replyToken"=>$replyToken,
            "messages"=>[$this->text_format($text)]
        );
        echo json_encode($payload);
        return $this->send($payload,'reply');
    }
    function send_flex($user_id,$datas){
        $payload = array(
            "to"=>array($user_id),
            "messages"=>[array(
                "type"=>"flex",
                "altText"=>"flex",
                "contents"=>$this->flex_format($datas)
            )]
        );
        return $this->send($payload,'send');
    }
    function resend_flex($replyToken,$datas){
        $payload = array(
            "replyToken"=>$replyToken,
            "messages"=>[array(
                "type"=>"flex",
                "altText"=>"flex",
                "contents"=>$this->flex_format($datas)
            )]
        );
        $res = $this->send($payload,'reply');
        print_r($res);
        return $res;

    }
    function test_flex($datas){
        echo json_encode($this->flex_format($datas));
    }


    /****************************************************************
     * 
     * 設定格式
     */
    function text_format($text){
        $res = array(
                "type"=>"text",
                "text"=>$text
        );
        return $res;
    }
    function img_format($src){
        $res = array(
                "type"=>"image",
                "originalContentUrl"=>$src,
                "previewImageUrl"=>$src,
        );
        return $res;
    }
    function flex_format($datas){
        $item = array();
        
        foreach ($datas as $key => $value) {
            unset($c);
            # code...
            $c[] = array(
                            "type"=>"text",
                            "text"=>$value['subject'],
                            "weight"=>"bold",
                            "size"=>"xl",
                            "wrap"=>true,
            );
            $c[] = array(
                            "type"=>"text",
                            "text"=>$value['info'],
                            "size"=>"sm",
                            "wrap"=>true,
            );
            foreach ($value['tables'] as $k => $v) {
                # code...
                $item = array(
                    array(
                        "type"=>"text",
                        "text"=>$v['title'],
                        "color"=>"#aaaaaa",
                        "size"=>"sm",
                        "flex"=>1
                    ),
                    array(
                        "type"=>"text",
                        "text"=>$v['info'],
                        "color"=>"#666666",
                        "size"=>"sm",
                        "flex"=>5,
                        "wrap"=>true
                    )
                );
                $c[] = array(
                    "type"=>"box",
                    "layout"=>"baseline",
                    "spacing"=>"sm",
                    "contents"=>$item
                );
            }
            
            $res[] = array(
                "type"=>"bubble",
                "action"=>array(
                        "type"=>"uri",
                        "uri"=>$value['uri']
                ),
                "hero"=>array(
                    "type"=>"image",
                    "url"=>$value['img'],
                    "size"=>"full",
                    "aspectMode"=>"cover",
                    "action"=>array(
                        "type"=>"uri",
                        "uri"=>$value['uri']
                    )
                    ),
                "body"=>array(
                    "type"=>"box",
                    "layout"=>"vertical",
                    "contents"=>$c
                ),
                "footer"=>array(
                    "type"=>"box",
                    "layout"=>"vertical",
                    "spacing"=>"sm",
                    "contents"=>array(
                        array(
                            "type"=>"button",
                            "style"=>"link",
                            "height"=>"sm",
                            "action"=>array(
                                "type"=>"uri",
                                "label"=>'前往訂購',
                                "uri"=>$value['uri']
                            )
                        )
                    )
                )
            );
        }

        
        $data = array(
            "type"=>"carousel",
            "contents"=>$res
        );
        return $data;
    }

    function getUserProfile($user_id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api.line.me/v2/bot/profile/'.$user_id );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->channelAccessToken
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        $user = json_decode($result, true);
        if(!isset($user['pictureUrl'])){
            $user['pictureUrl'] = '';
        }
        return $user;
    }

    function get_img($messageId){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,'https://api-data.line.me/v2/bot/message/'.$messageId.'/content' );
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,$api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            // 'Content-Type: application/json',
            'Authorization: Bearer ' . $this->channelAccessToken
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function send($payload,$act){
        
        switch($act){
            case 'send':
                $url = 'https://api.line.me/v2/bot/message/multicast';
            break;
            case 'reply':
                $url = 'https://api.line.me/v2/bot/message/reply';
            break;
            default:
                # code...
                break;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $this->channelAccessToken
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}