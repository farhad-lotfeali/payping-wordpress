<?php 


function pp_admin_affiliate(){
    if(isset($_GET['ac'])){
        $action = $_GET['ac'];
    }else{
        $action = '';
    }

    switch($action){
        case 'create_store':
            pp_affiliate_create_store();
            break;
        case 'create_distributor':
            pp_affiliate_create_distributor();
            break;
        default:
            pp_affiliate_list();
    }
}


function pp_affiliate_list()
{
    $api = new pp_Api();
    $affiliates = $api->store_list();
    if($affiliates->code < 200 || $affiliates->code >= 300){
        wp_die("در دریافت اطلاعات مشکلی رخ داده است");
    }
    $affiliates = $affiliates->body;
    require dirname(__FILE__). '/affiliate.html.php';
}

function pp_affiliate_create_store()
{
    if(!empty($_POST)){
        $api = new pp_Api();
        $params = $_POST;
        $params['isEnabled'] = true;
        $params['isPrivate'] = boolval($params['isPrivate']);
        $store = $api->create_store($params);
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
    require dirname(__FILE__). '/affiliate_store_create.html.php';
}

function pp_affiliate_create_distributor()
{
    if(!empty($_POST)){
        $api = new pp_Api();
        $params = $_POST;
        $store = $api->create_distributor($params);
        $err_message = [];

        if($store->code >= 200 && $store->code < 300){
            add_action( 'admin_notices_pp',function(){
                printf( '<div class="notice notice-success"><p>%1$s</p></div>','فروشنده با موفقیت ایجاد شد'); 
            });
            wp_redirect(admin_url('admin.php?page=payping-affiliate'), 302);
        }else{
            $err_message = $store->body;
        }
    }
    require dirname(__FILE__). '/affiliate_distributor_create.html.php';
}