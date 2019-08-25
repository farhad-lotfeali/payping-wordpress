<?php
//Add a WooCommerce order status (completed, refunded) into the Dashboard status widget
function woocommerce_add_order_status_dashboard_widget() {
	if ( ! current_user_can( 'edit_shop_orders' ) ) {
		return;
	}
	$price =0;
    if ( ! $price = wp_cache_get( 'balance', 'pp' ) ) {
        $api = new Api();
        $balance = $api->balance();
        $price = $balance->body->result;
        wp_cache_add( 'balance', $price, 'pp' ,60);
    }
	

	?>
	<li class="sales-this-month">
	<a href="<?= admin_url('admin.php?page=payping&ac=settle') ?>" tooltip="تسویه خساب">
		<?php
			/* translators: %s: order count */
			printf(
				_n( '<strong>%s تومان</strong> موجودی پی پینگ', '<strong>%s تومان</strong> موجودی پی پینگ', $price, 'woocommerce' ),
				$price
			);
		?>
		</a>
	</li>
	<li></li>
	<?php
}
add_action( 'woocommerce_after_dashboard_status_widget', 'woocommerce_add_order_status_dashboard_widget' );