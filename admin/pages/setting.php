<?php
add_action( 'admin_init', 'register_payping_settings' );


function register_payping_settings(){
    register_setting( 'payping', 'pp_token' );
}

function pp_admin_setting(){
    if(isset($_GET['ac'])){
        $action = $_GET['ac'];
    }else{
        $action = '';
    }
    switch($action){
        case 'club':
            break;
        default:
            require dirname(__FILE__). '/setting.html.php';
    }
}