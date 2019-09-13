<?php

function pp_cache($key,$value,$expite= 60){
    if(wp_cache_get($key)){
        return wp_cache_get($key);
    }else{
        wp_cache_add($key, $value, null, $expire);
        return $value;
    }
}

function pp_dump($item){
    echo '<pre dir="ltr">';
    var_dump($item);
    die();
}

/* Show Debug In Console */
function WC_GPP_Debug_Log($Debug_Mode='no', $object=null, $label=null )
{
    if($Debug_Mode === 'yes'){
        $object = $object; 
        $message = json_encode( $object, JSON_UNESCAPED_UNICODE);
        $label = "Debug".($label ? " ($label): " : ': '); 
        echo "<script>console.log(\"$label\", $message);</script>";

        file_put_contents(WC_GPPDIR.'/log_payping.txt', $label."\n".$message."\n\n", FILE_APPEND);
    }
}