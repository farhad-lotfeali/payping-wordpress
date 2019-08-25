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
    print_R($item);
    die();
}