<?php
/**
 * 2019-06-03 @ James
 * 後端製作資料分頁 lib
 * 將where過的資料陣列放到 datalist 中就可以擷取特定頁碼資料回傳
 * 
 * arr 完整資料陣列
 * items 單頁筆數
 * now_page 目前頁碼
 * 
 * 回傳值
 * datalist 已經擷取完成的資料
 * current_page 目前頁碼
 * total_count 總筆數
 * total_page 總頁數
 * 
 */
class Page
{
  // 取得items
  function items(){
    $CI = &get_instance();
    $CI->load->helper('url');

    if($CI->input->get_post('items') == ""){
        $items = 10;
    }else{
        $items = $CI->input->get_post('items');
    }
    return $items;
  }
  // 取得items
  function now_page(){
    $CI = &get_instance();
    $CI->load->helper('url');
    if($CI->input->get_post('now_page') == ""){
        $now_page = 1;
    }else{
        $now_page = $CI->input->get_post('now_page');
    }
    return $now_page;
  }


  // 完整輸出
  function pages_data($arr, $items, $now_page)
  {
    $data = $this->pages_config($arr, $items);
    $data['datalist'] = $this->datalist($arr, $items, $now_page);
    $data['current_page'] = $now_page;
    return $data;
  }
  // 單純取得資料
  function datalist($arr, $items, $now_page)
  {
    $count = count($arr);
    $start = ($now_page - 1) * $items;
    $end = $start + $items;
    $res = array();
    while (
      $start < $end
    ) {
      if (isset($arr[$start])) {
        $res[] = $arr[$start];
      }
      $start = $start + 1;
      # code...
    }
    return $res;
  }
  // 取得分頁設定資料
  function pages_config($arr, $items)
  {
    $res['total_count'] = count($arr);
    $res['total_page'] = ceil(count($arr) / $items);
    return $res;
  }
}
