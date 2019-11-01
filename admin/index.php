<?php
//check access
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if(!is_admin()) return;

require_once(dirname(__FILE__).'/pages/transaction.php');
require_once(dirname(__FILE__).'/pages/deposit.php');
require_once(dirname(__FILE__).'/pages/affiliate.php');
require_once(dirname(__FILE__).'/pages/setting.php');
require_once(dirname(__FILE__).'/pages/club.php');




add_action('admin_menu', 'pp_admin_menu');
function pp_admin_menu(){
    add_menu_page('پی پینگ', 'پی پینگ', 'manage_options', 'payping', 'pp_admin_main', 'dashicons-store',57);
    add_submenu_page('payping', 'تراکنش ها', 'تراکنش ها', 'manage_options', 'payping', 'pp_admin_main');
    add_submenu_page('payping', 'مغایرت گیری', 'مغایرت گیری', 'manage_options', 'payping-deposite', 'pp_admin_deposit');
    add_submenu_page('payping', 'همکاری در فروش', 'همکاری در فروش', 'manage_options', 'payping-affiliate', 'pp_admin_affiliate');
    add_submenu_page('payping', 'باشگاه مشتریان', 'باشگاه مشتریان', 'manage_options', 'payping-club', 'pp_admin_club');
    add_submenu_page('payping', 'تنظیمات', 'تنظیمات', 'manage_options', 'payping-setting', 'pp_admin_setting');
}

add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 999 );

function toolbar_link_to_mypage( $wp_admin_bar ) {
    if(get_current_screen()->id != 'toplevel_page_payping') return;
    global $price;
    $price =0;
    if ( ! $price = wp_cache_get( 'balance', 'pp' ) ) {
        $api = new pp_Api();
        $balance = $api->balance();
        $price = $balance->body->result;
        wp_cache_add( 'balance', $price, 'pp' ,60);
    }

    $title = 'موجودی پی پینگ: '.$price. ' تومان ';
	$args = array(
		'id'    => 'my_page',
		'title' => $title,
		'href'  => admin_url( 'admin.php?page=payping&ac=settle'),
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
}