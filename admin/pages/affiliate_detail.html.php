<div class="wrap">
    <?php do_action('admin_notices_pp'); ?>
    <div class="inside">
        <h2 class="wp-heading-inline">مشخصات فروشگاه </h2>
        <table class="widefat fixed" style="border: 1px solid #c9c9c9; border-collapse: collapse;">
            <tr>
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">کد</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $_GET['code'] ?></td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">نام</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['name'] ?></td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">آدرس اینترنتی فروشگاه</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['url'] ?></td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">نام توکن</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['clientName'] ?></td>


            </tr>
            <tr>
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">درصد</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['wage'] ?></td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">اعتبار</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['defaultExpireDays'] ?> روز </td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">نوع</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['isPrivate'] ? 'خصوصی' : 'عمومی' ?> روز </td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">توصیحات</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $store['description'] ?></td>

            </tr>
        </table>
    </div>
    <div class="inside">
        <h2>فروشندگان</h2>
        <table class="widefat fixed" style="border: 1px solid #c9c9c9; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #c9c9c9; text-align:center">نام</th>
                    <th style="border: 1px solid #c9c9c9; text-align:center">لینک</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($distributor)) : ?>
                    <tr>
                        <td colspan="2" style="text-align:center">فروشنده ای موجود نیست</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($distributor as $d) : ?>
                        <tr>
                            <td style="border: 1px solid #c9c9c9; text-align:center"><?= $d->name ?></td>
                            <td style="border: 1px solid #c9c9c9; text-align:center"><a href="https://ppng.ir/aff/<?= $d->code ?>">https://ppng.ir/aff/<?= $d->code ?></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>