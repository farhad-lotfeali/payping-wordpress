<?php
/*
Plugin Name:  PayPing Wordpress
Version: 0.0.0
Description:  افزونهمدیریت پی‌پینگ برای وردپرس
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
require_once(dirname(__FILE__) . "/gateways/woocommerce.php");
