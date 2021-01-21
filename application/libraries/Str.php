<?php
class Str 
{
    function clean_html($str){
        $config["show-body-only"]=true;
        $html = tidy_repair_string($str, $config);
        return $html;
    }
}
