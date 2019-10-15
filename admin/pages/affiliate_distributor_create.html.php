<div class="wrap">
    <h1 class="wp-heading-inline">افزودن فروشنده</h1>
    <?php do_action('admin_notices_pp'); ?>
    <form method="post" action="<?= admin_url('admin.php?page=payping-affiliate&ac=create_store') ?>">
        <div class="media-toolbar wp-filter" style="padding: 10px">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">ایمیل یا نام کاربری</th>
                        <td>
                            <input class="regular-text" type="text" name="name"  value=""/>
                            <?php if(isset($err_message->name)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->name?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">درصد</th>
                        <td>
                            <input class="regular-text" type="number" name="wage"  value=""/>
                            <?php if(isset($err_message->wage)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->wage?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>تاریخ اعتبار</th>
                        <td><input class="persian-date" type="text" name="defaultExpireDate" value="" /></td>
                    </tr>
                </table>
                <input type="hidden" name="storeCode" value="<?=$_GET['store_code']?>" />
        </div>
        <?php submit_button('افزودن فروشگاه'); ?>
    </form>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="<?= plugins_url() . '/payping/assets/js/persian-date.js' ?>"></script>
<script type="text/javascript" src="<?= plugins_url() . '/payping/assets/js/persian-datepicker.js' ?>"></script>
<script>
    $('.persian-date').persianDatepicker({
        observer: false,
        format: 'YYYY/MM/DD',
        initialValue: false
    });
</script>