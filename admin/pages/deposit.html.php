<div class="wrap">
    <h1 class="wp-heading-inline">مغایرت گیری  تراکنش ها</h1>
    <?php do_action('admin_notices'); ?>
    <table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
                <th style="text-align:center;" >تاریخ </th>
                <th style="text-align:center;" >شناسه پرداخت </th>
                <th style="text-align:center;" >شناسه فاکتور </th>
                <th style="text-align:center;" >مبلغ</th>
                <th></th>
			</tr>
		</thead>

		<tbody>

            <?php if($res->code < 200 || $res->code >= 300): ?>
                <tr><td colspan=5 style="color:red;text-align:center">در دریافت اطلاعات خطایی رخ داده</td></tr>
            <?php elseif(empty($res->body)): ?>
            <tr><td colspan=5 style="text-align:center">هیچ مغایرتی یافت نشد</td></tr>
            <?php else: ?>
            <?php foreach($res->body as $item): ?>
                <tr class='clickable-row' data-href='<?= admin_url('admin.php?page=payping&ac=resolve&') ?>'>
                    <td style="text-align:center"><strong dir="ltr"><?= jdate('Y-m-d H:i',strtotime($item->payDate)) ?></strong></td>
                    <td style="text-align:center"><span><?= $item->refId ?></span></td>
                    <td style="text-align:center"><span><?= $item->clientRefId ?></span></td>
                    <td style="text-align:center"><span><?= number_format($item->amount) ?> تومان</span></td>
                    <td><a href="" class="btn btn-primary">بروز رسانی سفارش</a></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
		</tbody>

		<tfoot>
			<tr>
                <th style="text-align:center;" >تاریخ </th>
                <th style="text-align:center;" >شناسه پرداخت </th>
                <th style="text-align:center;" >شناسه فاکتور </th>
                <th style="text-align:center;" >مبلغ</th>
                <th></th>
			</tr>
		</tfoot>
	</table>
</div>
