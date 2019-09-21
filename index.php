<?php
/*
Plugin Name:  افزونه مدیریت درگاه پرداخت پی پینگ
Version: 0.0.0
Description:  افزونه مدیریت پی‌پینگ برای وردپرس
Plugin URI: https://www.payping.ir/
Author: Farhad Lotfeali
Author URI: 
*/
if (!defined('ABSPATH')) exit;

require_once(dirname(__FILE__) . "/classes/api.class.php");
if (!function_exists('jdate')) require_once(dirname(__FILE__) . "/classes/jdf.php");
require_once(dirname(__FILE__) . "/classes/paginator.class.php");
require_once(dirname(__FILE__) . "/functions.php");
require_once(dirname(__FILE__) . "/admin/index.php");


global $ipgs;
$api = new pp_Api();
$ipgs = $api->ipgs()->body;

require_once(dirname(__FILE__) . "/gateways/woocommerce.php");
require_once(dirname(__FILE__) . "/gateways/restrict_content_pro.php");
