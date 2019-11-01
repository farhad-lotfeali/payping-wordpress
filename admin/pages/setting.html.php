<div class="wrap">
    <h1 class="wp-heading-inline">تنظیمات افزونه PayPing</h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'payping' ); ?>
        <?php do_settings_sections( 'payping' ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">توکن پی پینگ</th>
            <td><input class="regular-text" type="text" name="pp_token" value="<?php echo esc_attr( get_option('pp_token') ); ?>" /><a class="button button-primary" href="https://ppng.ir/aff/gS4n" target="_blank">توکن</a></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
