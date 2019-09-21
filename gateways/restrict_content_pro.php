<?php

if (!defined('ABSPATH')) {

	die('This file cannot be accessed directly');
}

if (!class_exists('RCP_PayPing')) {

	class RCP_PayPing
	{
        private $key;
        private $title;

		public function __construct($key,$title)
		{
            $this->key = $key;
            $this->title = $title;
			add_action('init', array($this, 'PayPing_Verify'));
			add_action('rcp_payments_settings', array($this, 'PayPing_Setting'));
			add_action('rcp_gateway_PayPing', array($this, 'PayPing_Request'));

			add_filter('rcp_payment_gateways', array($this, 'PayPing_Register'));

			if (!function_exists('PayPing_Currencies') && !function_exists('PayPing_Currencies')) {

				add_filter('rcp_currencies', array($this, 'PayPing_Currencies'));
			}
		}

		public function PayPing_Currencies($currencies)
		{
			unset($currencies['RIAL']);

			$currencies['تومان'] = __('تومان', 'rcp_PayPing');
			$currencies['ریال'] = __('ریال', 'rcp_PayPing');

			return $currencies;
		}
				
		public function PayPing_Register($gateways)
		{
			global $rcp_options;

			$PayPing = $this->title;

			if (version_compare(RCP_PLUGIN_VERSION, '2.1.0', '<')) {

				$gateways[$this->key] = isset($rcp_options[$this->key.'_name']) ? $rcp_options[$this->key.'_name'] : __($PayPing, 'rcp_PayPing');

			} else {

				$gateways[$this->key] = array(

					'label'       => isset($rcp_options[$this->key.'_name']) ? $rcp_options[$this->key.'_name'] : __($PayPing, 'rcp_PayPing'),
					'admin_label' => isset($rcp_options[$this->key.'_name']) ? $rcp_options[$this->key.'_name'] : __($PayPing, 'rcp_PayPing'),
				);
			}

			return $gateways;
		}

		public function PayPing_Setting($rcp_options)
		{
		?>	
			<hr/>
			<table class="form-table">
				<?php do_action('RCP_PayPing_before_settings', $rcp_options); ?>
				<tr valign="top">
					<th colspan="2">
						<h3><?php _e('  تنظیمات پرداخت از طریق '.$this->title, 'rcp_PayPing'); ?></h3>
					</th>
				</tr>
				<input class="regular-text" id="rcp_settings[<?=$this->key?>_api]" style="width:300px;" name="rcp_settings[<?=$this->key?>_api]" type="hidden" value="<?php if (!empty(get_option('pp_token'))) { echo get_option('pp_token'); } ?>"/>
				<tr valign="top">
					<th>
						<label for="rcp_settings[<?=$this->key?>_query_name]"><?php _e('نام لاتین درگاه پرداخت', 'rcp_PayPing'); ?></label>
					</th>
					<td>
						<input class="regular-text" id="rcp_settings[<?=$this->key?>_query_name]" style="width:300px;" name="rcp_settings[<?=$this->key?>_query_name]" value="<?php echo isset($rcp_options[$this->key.'_query_name']) ? $rcp_options[$this->key.'_query_name'] : 'PayPing'; ?>"/>
						<div class="description"><?php _e('این نام در هنگام بازگشت از بانک در آدرس بازگشت از بانک نمایان خواهد شد<br/>این نام باید با نام سایر درگاه ها متفاوت باشد', 'rcp_PayPing'); ?></div>
					</td>
				</tr>
				<tr valign="top">
					<th>
						<label for="rcp_settings[<?=$this->key?>_name]"><?php _e('نام نمایشی درگاه پرداخت', 'rcp_PayPing'); ?></label>
					</th>
					<td>
						<input class="regular-text" id="rcp_settings[<?=$this->key?>_name]" style="width:300px;" name="rcp_settings[<?=$this->key?>_name]" value="<?php echo isset($rcp_options[$this->key.'_name']) ? $rcp_options[$this->key.'_name'] : __('پرداخت از طریق درگاه پی‌پینگ', 'rcp_PayPing'); ?>"/>
					</td>
				</tr>
				<tr valign="top">
					<th>
						<label><?php _e('تذکر ', 'rcp_PayPing'); ?></label>
					</th>
					<td>
						<div class="description"><?php _e('از سربرگ مربوط به ثبت نام در تنظیمات افزونه حتما یک برگه برای بازگشت از بانک انتخاب نمایید<br/>ترجیحا نامک برگه را لاتین قرار دهید<br/> نیازی به قرار دادن شورت کد خاصی در برگه نیست و میتواند برگه ی خالی باشد', 'rcp_PayPing'); ?></div>
					</td>
				</tr>
				<?php do_action('RCP_PayPing_after_settings', $rcp_options); ?>
			</table>
			<?php
		}
		
		public function PayPing_Request($subscription_data)
		{
			$new_subscription_id = get_user_meta($subscription_data['user_id'], 'rcp_subscription_level', TRUE);

			if (!empty($new_subscription_id)) {

				update_user_meta($subscription_data['user_id'], 'rcp_subscription_level_new', $new_subscription_id);
			}
			
			$old_subscription_id = get_user_meta($subscription_data['user_id'], 'rcp_subscription_level_old', TRUE);

			update_user_meta($subscription_data['user_id'], 'rcp_subscription_level', $old_subscription_id);
			
			global $rcp_options;

			ob_start();

			$query  = isset($rcp_options[$this->key.'_query_name']) ? $rcp_options[$this->key.'_query_name'] : 'PayPing-'.$this->key;
			$amount = str_replace(',', '', $subscription_data['price']);

			$PayPing_payment_data = array(

				'user_id'           => $subscription_data['user_id'],
				'subscription_name' => $subscription_data['subscription_name'],
				'subscription_key'  => $subscription_data['key'],
				'amount'            => $amount
			);		
			

			@session_start();

			$_SESSION[$this->key.'_payment_data'] = $PayPing_payment_data;

			do_action('RCP_Before_Sending_to_PayPing', $subscription_data);

			if (extension_loaded('curl')) {

				$currency = $rcp_options['currency'];
				

				if ($currency == 'تومان' || $currency == 'TOMAN' || $currency == 'تومان ایران' || $currency == 'IRT' || $currency == 'Iranian Toman') {

					$amount = $amount * 10;
				}

				$api_key  = !empty(get_option('pp_token')) ? get_option('pp_token') : NULL;
				$callback = add_query_arg('gateway', $query, $subscription_data['return_url']);

				$params = array(

					'api'          => $api_key,
					'amount'       => intval($amount),
					'redirect'     => urlencode($callback),
					'factorNumber' => $subscription_data['post_data']['rcp_register_nonce']
				);

				

				$result = $this->common('https://pay.ir/pg/send', $params);

				if ($result && isset($result->status) && $result->status == 1) {

					$gateway_url = 'https://pay.ir/pg/' . $result->token;

					wp_redirect($gateway_url);

				} else {

					$fault = 'در ارتباط با وب سرویس Pay.ir خطایی رخ داده است';
					$fault = isset($result->errorMessage) ? $result->errorMessage : $fault;

					wp_die(sprintf(__('متاسفانه پرداخت به دلیل خطای زیر امکان پذیر نمی باشد<br/><b>%s</b>', 'rcp_PayPing'), $fault));
				}

			} else {

				$fault = 'تابع cURL در سرور فعال نمی باشد';

				wp_die(sprintf(__('متاسفانه پرداخت به دلیل خطای زیر امکان پذیر نمی باشد<br/><b>%s</b>', 'rcp_PayPing'), $fault));
			}

			exit;
		}
		
		public function PayPing_Verify()
		{
			if (!isset($_GET['gateway'])) {

				return;
			}

			if (!class_exists('RCP_Payments')) {

				return;
			}

			global $rcp_options, $wpdb, $rcp_payments_db_name;
			

			@session_start();

			$PayPing_payment_data = isset($_SESSION[$this->key.'_payment_data']) ? $_SESSION[$this->key.'_payment_data'] : NULL;
			

			$query = isset($rcp_options[$this->key.'_query_name']) ? $rcp_options[$this->key.'_query_name'] : 'PayPing';

			if (($_GET['gateway'] == $query) && $PayPing_payment_data) {

				$user_id           = $PayPing_payment_data['user_id'];
				$subscription_name = $PayPing_payment_data['subscription_name'];
				$subscription_key  = $PayPing_payment_data['subscription_key'];
				$amount            = $PayPing_payment_data['amount'];
				

				$payment_method = isset($rcp_options[$this->key.'_name']) ? $rcp_options[$this->key.'_name'] : __('درگاه پرداخت و کیف پول الکترونیک Pay.ir', 'rcp_PayPing');

				$new_payment = TRUE;

				$get_result = $wpdb->get_results($wpdb->prepare("SELECT id FROM " . $rcp_payments_db_name . " WHERE `subscription_key`='%s' AND `payment_type`='%s';", $subscription_key, $payment_method));

				if ($get_result) {

					$new_payment = FALSE;
				}

				unset($GLOBALS[$this->key.'_new']);

				$GLOBALS[$this->key.'_new'] = $new_payment;

				global $new;

				$new = $new_payment;

				if ($new_payment == 1) {

					if (isset($_GET['status']) && isset($_GET['token'])) {

						$status        = sanitize_text_field($_GET['status']);
						$token      = sanitize_text_field($_GET['token']);
						$message       = sanitize_text_field($_GET['message']);

						if (isset($status) && $status == 1) {

							$api_key = !empty(get_option('pp_token')) ? get_option('pp_token') : NULL;

							$params = array (

								'api'     => $api_key,
								'token' => $token
							);

							$result = $this->common('https://pay.ir/pg/verify', $params);

							if ($result && isset($result->status) && $result->status == 1) {

								$card_number = isset($result->cardNumber) ? sanitize_text_field($result->cardNumber) : 'Null';
                                $factor_number = isset($result->factorNumber) ? sanitize_text_field($result->factorNumber) : 'Null';

                                $currency = $rcp_options['currency'];
								
								if ($currency == 'تومان' || $currency == 'TOMAN' || $currency == 'تومان ایران' || $currency == 'IRT' || $currency == 'Iranian Toman') {

									$amount = $amount * 10;
								}

								if (intval($amount) == $result->amount) {

									$fault = NULL;

									$payment_status = 'completed';
									$transaction_id = $result->transId;

								} else {

									$fault = 'رقم تراكنش با رقم پرداخت شده مطابقت ندارد';

									$payment_status = 'failed';
									$transaction_id = $result->transId;
								}

							} else {

								$fault = 'در ارتباط با وب سرویس Pay.ir و بررسی تراکنش خطایی رخ داده است';
								$fault = isset($result->errorMessage) ? $result->errorMessage : $fault;

								$payment_status = 'failed';
								$transaction_id = $result->transId;
							}

						} else {

							if ($message) {

								$fault = $message;

								$payment_status = 'failed';
								$transaction_id = $GLOBALS[$this->key.'_transaction_id'];

							} else {

								$fault = 'تراكنش با خطا مواجه شد و یا توسط پرداخت کننده کنسل شده است';

								$payment_status = 'cancelled';
								$transaction_id = $GLOBALS[$this->key.'_transaction_id'];
							}
						}

					} else {

						$fault = 'اطلاعات ارسال شده مربوط به تایید تراکنش ناقص و یا غیر معتبر است';

						$payment_status = 'failed';
						$transaction_id = NULL;
					}

					unset($GLOBALS[$this->key.'_payment_status']);
					unset($GLOBALS[$this->key.'_transaction_id']);
					unset($GLOBALS[$this->key.'_fault']);
					unset($GLOBALS[$this->key.'_subscription_key']);

					$GLOBALS[$this->key.'_payment_status']   = $payment_status;
					$GLOBALS[$this->key.'_transaction_id']   = $transaction_id;
					$GLOBALS[$this->key.'_subscription_key'] = $subscription_key;
					$GLOBALS[$this->key.'_fault']            = $fault;

					global $PayPing_transaction;

					$PayPing_transaction = array();

					$PayPing_transaction[$this->key.'_payment_status']   = $payment_status;
					$PayPing_transaction[$this->key.'_transaction_id']   = $transaction_id;
					$PayPing_transaction[$this->key.'_subscription_key'] = $subscription_key;
					$PayPing_transaction[$this->key.'_fault']            = $fault;

					if ($payment_status == 'completed') {

						$payment_data = array(

							'date'             => date('Y-m-d g:i:s'),
							'subscription'     => $subscription_name,
							'payment_type'     => $payment_method,
							'subscription_key' => $subscription_key,
							'amount'           => $PayPing_payment_data['amount'],
							'user_id'          => $user_id,
							'transaction_id'   => $transaction_id
						);

						do_action('RCP_PayPing_Insert_Payment', $payment_data, $user_id);

						$rcp_payments = new RCP_Payments();

						$rcp_payments->insert($payment_data);

						$new_subscription_id = get_user_meta($user_id, 'rcp_subscription_level_new', TRUE);

						if (!empty($new_subscription_id)) {

							update_user_meta($user_id, 'rcp_subscription_level', $new_subscription_id);
						}

						rcp_set_status($user_id, 'active');

						if (version_compare(RCP_PLUGIN_VERSION, '2.1.0', '<')) {

							rcp_email_subscription_status($user_id, 'active');

							if (! isset($rcp_options['disable_new_user_notices'])) {

								wp_new_user_notification($user_id);
							}
						}

						update_user_meta($user_id, 'rcp_payment_profile_id', $user_id);
						update_user_meta($user_id, 'rcp_signup_method', 'live');
						update_user_meta($user_id, 'rcp_recurring', 'no'); 
					
						$subscription = rcp_get_subscription_details(rcp_get_subscription_id($user_id));
						$member_new_expiration = date('Y-m-d H:i:s', strtotime('+' . $subscription->duration . ' ' . $subscription->duration_unit . ' 23:59:59'));

						rcp_set_expiration_date($user_id, $member_new_expiration);
						delete_user_meta($user_id, '_rcp_expired_email_sent');

						$post_title   = __('تایید پرداخت', 'rcp_PayPing');
						$post_content = __('پرداخت با موفقیت انجام شد شماره تراکنش: ' . $transaction_id, 'rcp_PayPing') . __(' روش پرداخت: ', 'rcp_PayPing');

						$log_data = array(

							'post_title'   => $post_title,
							'post_content' => $post_content . $payment_method,
							'post_parent'  => 0,
							'log_type'     => 'gateway_error'
						);

						$log_meta = array(

							'user_subscription' => $subscription_name,
							'user_id'           => $user_id
						);

						$log_entry = WP_Logging::insert_log($log_data, $log_meta);

						do_action('RCP_PayPing_Completed', $user_id);
					}

					if ($payment_status == 'cancelled') {

						$post_title   = __('انصراف از پرداخت', 'rcp_PayPing');
						$post_content = __('تراکنش به دلیل خطای رو به رو ناموفق باقی ماند: ', 'rcp_PayPing') . $fault . __(' روش پرداخت: ', 'rcp_PayPing');

						$log_data = array(

							'post_title'   => $post_title,
							'post_content' => $post_content . $payment_method,
							'post_parent'  => 0,
							'log_type'     => 'gateway_error'
						);

						$log_meta = array(

							'user_subscription' => $subscription_name,
							'user_id'           => $user_id
						);

						$log_entry = WP_Logging::insert_log($log_data, $log_meta);

						do_action('RCP_PayPing_Cancelled', $user_id);
					}

					if ($payment_status == 'failed') {

						$post_title   = __('خطا در پرداخت', 'rcp_PayPing');
						$post_content = __('تراکنش به دلیل خطای رو به رو ناموفق باقی ماند: ', 'rcp_PayPing') . $fault . __(' روش پرداخت: ', 'rcp_PayPing');

						$log_data = array(

							'post_title'   => $post_title,
							'post_content' => $post_content . $payment_method,
							'post_parent'  => 0,
							'log_type'     => 'gateway_error'
						);

						$log_meta = array(

							'user_subscription' => $subscription_name,
							'user_id'           => $user_id
						);

						$log_entry = WP_Logging::insert_log($log_data, $log_meta);

						do_action('RCP_PayPing_Failed', $user_id);
					}
				}

				add_filter('the_content', array($this, $this->key.'_Content_After_Return'));
			}
		}

		public function PayPing_Content_After_Return($content)
		{ 
			global $PayPing_transaction, $new;

			@session_start();

			$new_payment = isset($GLOBALS[$this->key.'_new']) ? $GLOBALS[$this->key.'_new'] : $new;
			
			$payment_status = isset($GLOBALS[$this->key.'_payment_status']) ? $GLOBALS[$this->key.'_payment_status'] : $PayPing_transaction[$this->key.'_payment_status'];
			$transaction_id = isset($GLOBALS[$this->key.'_transaction_id']) ? $GLOBALS[$this->key.'_transaction_id'] : $PayPing_transaction[$this->key.'_transaction_id'];

			$fault = isset($GLOBALS[$this->key.'_fault']) ? $GLOBALS[$this->key.'_fault'] : $PayPing_transaction[$this->key.'_fault'];
			
			if ($new_payment == 1)  {
			
				$PayPing_data = array(

					'payment_status' => $payment_status,
					'transaction_id' => $transaction_id,
					'fault'          => $fault
				);
				
				$_SESSION[$this->key.'_data'] = $PayPing_data;
			
			} else {

				$PayPing_payment_data = isset($_SESSION[$this->key.'_data']) ? $_SESSION[$this->key.'_data'] : NULL;
			
				$payment_status = isset($PayPing_payment_data['payment_status']) ? $PayPing_payment_data['payment_status'] : NULL;
				$transaction_id = isset($PayPing_payment_data['transaction_id']) ? $PayPing_payment_data['transaction_id'] : NULL;

				$fault = isset($PayPing_payment_data['fault']) ? $PayPing_payment_data['fault'] : NULL;
			}

			$message = NULL;

			if ($payment_status == 'completed') {

				$message = '<br/>' . __('تراکنش با موفقیت انجام شد. شماره پیگیری تراکنش ', 'rcp_PayPing') . $transaction_id . '<br/>';
			}

			if ($payment_status == 'cancelled') {

				$message = '<br/>' . __('تراکنش به دلیل انصراف شما نا تمام باقی ماند', 'rcp_PayPing');
			}

			if ($payment_status == 'failed') {

				$message = '<br/>' . __('تراکنش به دلیل خطای زیر ناموفق باقی باند', 'rcp_PayPing') . '<br/>' . $fault . '<br/>';
			}

			return $content . $message;
		}

		private static function common($url, $params)
		{
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

			$response = curl_exec($ch);
			$error    = curl_errno($ch);

			curl_close($ch);

			$output = $error ? FALSE : json_decode($response);

			return $output;
		}
	}
}

new RCP_PayPing('payping' ,' درگاه پرداخت پی پینگ');

global $ipgs;
foreach($ipgs as $ipg){
    new RCP_PayPing($ipg->ipgName,$ipg->title);
}

if (!function_exists('change_cancelled_to_pending')) {	

	add_action('rcp_set_status', 'change_cancelled_to_pending', 10, 2);

	function change_cancelled_to_pending($status, $user_id)
	{
		if ($status == 'cancelled') {

			rcp_set_status($user_id, 'expired');

			return TRUE;
		}
	}
}

if (!function_exists('RCP_User_Registration_Data') && !function_exists('RCP_User_Registration_Data')) {

	add_filter('rcp_user_registration_data', 'RCP_User_Registration_Data');

	function RCP_User_Registration_Data($user)
	{
		$old_subscription_id = get_user_meta($user['id'], 'rcp_subscription_level', TRUE);

		if (!empty($old_subscription_id)) {

			update_user_meta($user['id'], 'rcp_subscription_level_old', $old_subscription_id);
		}

		$user_info = get_userdata($user['id']);
		
		$old_user_role = implode(', ', $user_info->roles);

		if (!empty($old_user_role)) {

			update_user_meta($user['id'], 'rcp_user_role_old', $old_user_role);
		}

		return $user;
	}
}
