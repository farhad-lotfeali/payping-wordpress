<div class="wrap">
    <h1 class="wp-heading-inline">تنظیمت افزونه PayPing</h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'payping' ); ?>
        <?php do_settings_sections( 'payping' ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">توکن پی پینگ</th>
            <td><input class="regular-text" type="text" name="pp_token" value="<?php echo esc_attr( get_option('pp_token') ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>