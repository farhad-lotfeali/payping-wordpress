<div class="wrap">
    <h1 class="wp-heading-inline">تسویه حساب</h1>
    <?php do_action('admin_notices_pp'); ?>
    <div class="media-toolbar wp-filter" style="padding: 10px">
        <form method="post" action="<?= admin_url('admin.php?page=payping&ac=settle') ?>">
            <table class="form-table">
                <tr valign="top">
                <th scope="row">مبلغ تسویه</th>
                <td><input class="regular-text" type="text" name="pp_amount"  value="<?php global $price; echo $price; ?>"/> تومان</td>
                </tr>
            </table>
            <?php submit_button('تسویه'); ?>
        </form>
    </div>
</div>