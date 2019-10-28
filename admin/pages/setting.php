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
            pp_admin_setting_bonus();
            break;
        default:
            require dirname(__FILE__). '/setting.html.php';
    }
}


function pp_admin_setting_bonus(){
    if(!empty($_POST)){
        $api = new pp_Api();
        $params = $_POST;
        $store = $api->add_bonus($params);
        $err_message = [];

        if($store->code >= 200 && $store->code < 300){
            add_action( 'admin_notices_pp',function(){
                printf( '<div class="notice notice-success"><p>%1$s</p></div>','فروشگاه با موفقیت ایجاد شد'); 
            });
            wp_redirect(admin_url('admin.php?page=payping-affiliate'), 302);
        }else{
            $err_message = $store->body;
        }
    }
    require dirname(__FILE__). '/setting_bonus.html.php';
}