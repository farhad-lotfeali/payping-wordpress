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
                        <th scope="row">درصد</th>
                        <td>
                            <input class="regular-text" type="number" name="wage"  value=""/>
                            <?php if(isset($err_message->wage)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->wage?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">اعتبار(تعداد روز)</th>
                        <td>
                            <input class="regular-text" type="number" name="defaultExpireDays"  value=""/>
                            <?php if(isset($err_message->defaultExpireDays)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->defaultExpireDays?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">لینک عمومی</th>
                        <td>
                            <input class="regular-text" type="hidden" name="isPrivate"  value="false"/>
                            <input class="regular-text" type="checkbox" name="isPrivate"  value="true"/>
                            <?php if(isset($err_message->isPrivate)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->isPrivate?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">انتخاب توکن (clientID توکن شما)</th>
                        <td>
                            <input class="regular-text" type="text" name="clientId"  value=""/>
                            <?php if(isset($err_message->clientId)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->clientId?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">آدرس اینترنتی فروشگاه شما</th>
                        <td>
                            <input class="regular-text" type="url" name="url"  value=""/>
                            <?php if(isset($err_message->url)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->url?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">لوگوی فروشگاه</th>
                        <td>
                            <input class="regular-text" type="text" name="pic"  value=""/>
                            <?php if(isset($err_message->pic)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->pic?></p><?php endif; ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">توضیحات</th>
                        <td>
                            <input class="regular-text" type="text" name="description"  value=""/>
                            <?php if(isset($err_message->description)): ?><p class="description" id="tagline-description" style="color:red"><?=$err_message->description?></p><?php endif; ?>
                        </td>
                    </tr>
                </table>
            
        </div>
        <?php submit_button('افزودن فروشگاه'); ?>
    </form>
</div>