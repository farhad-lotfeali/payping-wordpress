<div class="wrap">
    <h1 class="wp-heading-inline">ساخت فروشگاه</h1>
    <?php do_action('admin_notices_pp'); ?>
    <form method="post" action="<?= admin_url('admin.php?page=payping-affiliate&ac=create_store') ?>">
        <div class="media-toolbar wp-filter" style="padding: 10px">
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">نام</th>
                        <td>
                            <input class="regular-text" type="text" name="name"  value=""/>
                            <?php if(isset($err_message->name)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->name?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">نام تجاری</th>
                        <td>
                            <input class="regular-text" type="text" name="businessName"  value=""/>
                            <?php if(isset($err_message->businessName)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->businessName?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">ایمیل</th>
                        <td>
                            <input class="regular-text" type="email" name="email"  value=""/>
                            <?php if(isset($err_message->email)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->email?></p><?php endif; ?>
                        </td>
                    </tr>
                
                </table>
            
        </div>
        <?php submit_button('افزودن باشگاه مشتریان'); ?>
    </form>
</div>