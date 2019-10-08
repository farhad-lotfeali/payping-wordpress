<div class="wrap">
    <h1 class="wp-heading-inline">مدیریت فروشگاه ها</h1>
    <a href="<?= admin_url('admin.php?page=payping-affiliate&ac=create_store') ?>" class="page-title-action">افزودن فروشگاه</a>
    <?php do_action('admin_notices_pp'); ?>
    <table class="wp-list-table widefat fixed striped" cellspacing="0">
		<thead>
			<tr>
                <th style="text-align:center;" >نام</th>
                <th style="text-align:center;" >درصد</th>
                <th style="text-align:center;" >اعتبار</th>
                <th style="text-align:center;" >نوع</th>
                <th style="text-align:center;" >نام توکن</th>
                <th style="text-align:center;" >لینک فروشگاه</th>
                <th style="text-align:center;" >ایجاد فروشنده</th>
			</tr>
		</thead>

		<tbody>
            <?php foreach($affiliates as $af): ?>
            <tr>
                <td style="text-align:center;"><?= $af->name ?></td>
                <td style="text-align:center;"><?= $af->wage ?></td>
                <td style="text-align:center;"><?= $af->defaultExpireDays ?></td>
                <td style="text-align:center;"><?= $af->isPrivate?'اختصاصی':'عمومی' ?></td>
                <td style="text-align:center;"><?= $af->clientName ?></td>
                <td style="text-align:center;"><a href="http://ppng.ir/aff/<?=$af->code?>">http://ppng.ir/aff/<?=$af->code?></a></td>
                <td style="text-align:center;"><a href="<?=admin_url('admin.php?page=payping-affiliate&ac=create_distributor')?>">+ فروشنده اختصاصی...</a></td>
            </tr>
            <?php endforeach; ?>
		</tbody>

		<tfoot>
			<tr>
                <th style="text-align:center;" >نام</th>
                <th style="text-align:center;" >درصد</th>
                <th style="text-align:center;" >اعتبار</th>
                <th style="text-align:center;" >نوع</th>
                <th style="text-align:center;" >نام توکن</th>
                <th style="text-align:center;" >لینک فروشگاه</th>
                <th style="text-align:center;" >ایجاد فروشنده</th>
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
  window.location.href = $(this).data("href");
        });
    });

    $('.persian-date').persianDatepicker({
        observer: false,
        format: 'YYYY/MM/DD',
        initialValue: false
    });
</script>
