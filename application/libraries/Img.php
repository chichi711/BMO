<?php 
class Img{
    function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen( $output_file, 'wb' ); 
        $data = explode(',', $base64_string );
        
        fwrite( $ifp, base64_decode( $data[1] ) );
        fclose( $ifp ); 
        return $output_file; 
    }
    function binary2img($binary,$output_file){
        $newFile = fopen($output_file,'w');//開啟檔案準備寫入
        fwrite($newFile,$binary);//寫入二進位制流到檔案
        fclose($newFile);
    }
}