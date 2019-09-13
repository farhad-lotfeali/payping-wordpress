<div class="wrap">
    <h1 class="wp-heading-inline">جزییات تراکنش</h1>
    <?php do_action('admin_notices_pp'); ?>
    <div class="card">
        <h3>لینک پرداخت تراکنش : <a target="_blank" href="https://ppng.ir/p/<?= $_GET['code'] ?>" >https://ppng.ir/p/<?= $_GET['code'] ?></a></h3>
    </div>
    <div class="inside">
        <h2 class="wp-heading-inline">مشخصات درخواست کننده </h2>
        <table class="widefat fixed" style="border: 1px solid #c9c9c9; border-collapse: collapse;">
            <tr>
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">کد</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $_GET['code'] ?></td>

                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">تاریخ درخواست</th>
                <td style="border: 1px solid #c9c9c9; text-align:center" ><strong dir="ltr"><?= pp_jdate('Y-m-d H:i',strtotime($transaction->reqDate)) ?></strong></td>
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">تاریخ پرداخت</th>
                <td style="border: 1px solid #c9c9c9; text-align:center" ><strong dir="ltr"><?= pp_jdate('Y-m-d H:i',strtotime($transaction->payDate)) ?></strong></td>
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">نام پرداخت کننده</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $transaction->name ?></td>
            </tr>
            <tr>
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">پرداخت کننده</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $transaction->payerIdentity ?></td>
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">مبلغ</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= number_format($transaction->amount) ?> تومان</td>
                
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">شناسه پرداخت</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $transaction->invoiceNo ?></td>
            
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">کارمزد</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= number_format($transaction->wage) ?> تومان</td>
            </tr>
            <tr>    
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">درگاه پرداخت کننده</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $transaction->ipgName ?></td>
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">درخواست/پرداخت</th>
                <td style="border: 1px solid #c9c9c9; text-align:center" ><?= boolval($transaction->isPaid)?'<span style="color:green">درخواست شده</span>':'<span style=" color:red">درخواست نشده</span>' ?></td>
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">تاییدیه پرداخت</th>
                <td style="border: 1px solid #c9c9c9; text-align:center" ><?= boolval($transaction->isPaid)?'<span style="color:green">پرداخت شده</span>':'<span style=" color:red">پرداخت نشده</span>' ?></td>
            
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">سیستم عامل پرداخت کننده</th>
                <td style="border: 1px solid #c9c9c9; text-align:center"><?= $transaction->platform ?> / <?= $transaction->browser ?></td>
            </tr>
            <tr>
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">شماره کارت پرداخت کننده</th>
                <td><?= $transaction->rrn ?></td>   
                
                
                <th style="border: 1px solid #c9c9c9; font-weight: bold; text-align: reight;">توضیخات</th>
                <td colspan=5><?= $transaction->description ?></td>
            </tr>
        </table>
    </div>
    <div class="inside">
        <h1>تاریخچه وضعیت پرداخت</h1>
        <table class="widefat fixed" style="border: 1px solid #c9c9c9; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #c9c9c9; text-align:center">IP</th>
                <th style="border: 1px solid #c9c9c9; text-align:center">IP ایرانی است</th>
                <th style="border: 1px solid #c9c9c9; text-align:center">مشخصات</th>
                <th style="border: 1px solid #c9c9c9; text-align:center">تاریخ ایجاد</th>
                <th style="border: 1px solid #c9c9c9; text-align:center">توضیحات</th>
                <th style="border: 1px solid #c9c9c9; text-align:center">شناسه درخواست</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($status_history)): ?>

            <?php else: ?>
                <?php foreach($status_history as $sh): ?>
                    <tr>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><?=$sh->ip?></td>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><?=($sh->isIranIp)?'بله':'خیر'?></td>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><?=$sh->userAgent?></td>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><strong dir="ltr"><?= pp_jdate('Y-m-d H:i',strtotime($sh->createDate)) ?></strong></td>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><?=$sh->description?></td>
                        <td style="border: 1px solid #c9c9c9; text-align:center"><?=strval($sh->requestId)?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>