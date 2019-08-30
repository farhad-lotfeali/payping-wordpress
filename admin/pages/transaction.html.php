<div class="wrap">
    <h1 class="wp-heading-inline">تراکنش های انجام شده توسط PayPing</h1>
    <?php do_action('admin_notices_pp'); ?>
    <div class="media-toolbar wp-filter" style="padding: 10px">
        <form id="hash_form">
            <input type="hidden" name="page" value="payping">
            <input type="text" name="filter" placeholder="جستجو در تراکنش ها">
            <input type="text" class="persian-date" name="from" placeholder="از تاریخ">
            <input type="text" class="persian-date" name="to" placeholder="تا تاریخ">
            <select name="type" id="type" style="width:100px">
                <option value="-1">همه</option>
                <option value="6">دریافتی</option>
                <option value="7">پرداختی</option>
            </select>
            <button type="submit" id="base_btn" class="button button-primary">جستجو</button>
        </form>
    </div>
    <table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
                <th style="text-align:center;" >تاریخ </th>
                <th style="text-align:center;" >کد پرداخت </th>
                <th style="text-align:center;" >پرداخت کننده </th>
                <th style="text-align:center;" >وضعیت </th>
				<th style="text-align:center;" >مبلغ</th>
			</tr>
		</thead>

		<tbody>

            <?php if($res->code < 200 || $res->code >= 300): ?>
                <tr><td colspan=5 style="color:red;text-align:center">در دریافت اطلاعات خطایی رخ داده</td></tr>
            <?php elseif(empty($res->body)): ?>
            <tr><td colspan=5 style="text-align:center">هیچ تراکنشی انجام نشده است</td></tr>
            <?php else: ?>
            <?php foreach($res->body as $item): ?>
                <tr class='clickable-row' data-href='<?= admin_url('admin.php?page=payping&ac=detail&code='.$item->code) ?>'>
                    <td style="text-align:center"><strong dir="ltr"><?= pp_jdate('Y-m-d H:i',strtotime($item->payDate)) ?></strong></td>
                    <td style="text-align:center"><span><?= $item->code ?></span></td>
                    <td style="text-align:center"><span><?= empty($item->name)?'-':$item->name ?></span></td>
                    <td style="text-align:center"><?= boolval($item->isPaid)?'<span style="color:green">پرداخت شده</span>':'<span style="color:red">پرداخت نشده</span>' ?></td>
                    <td style="text-align:center"><span><?= number_format($item->amount) ?> تومان</span></td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>
		</tbody>

		<tfoot>
			<tr>
            <th style="text-align:center;" >تاریخ </th>
                <th style="text-align:center;" >کد پرداخت </th>
                <th style="text-align:center;" >پرداخت کننده </th>
                <th style="text-align:center;" >وضعیت </th>
				<th style="text-align:center;" >مبلغ</th>
			</tr>
		</tfoot>
	</table>

</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="<?= plugins_url() . '/payping/assets/js/persian-date.js' ?>"></script>
<script type="text/javascript" src="<?= plugins_url() . '/payping/assets/js/persian-datepicker.js' ?>"></script>
<script>
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.open($(this).data("href"),'_blank');
        });
    });

    $('.persian-date').persianDatepicker({
        observer: false,
        format: 'YYYY/MM/DD',
        initialValue: false
    });
</script>
