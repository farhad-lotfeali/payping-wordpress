<?php
function pp_admin_main(){

    if(isset($_GET['ac'])){
        $action = $_GET['ac'];
    }else{
        $action = '';
    }
    switch($action){
        case 'detail':
            pp_transaction_detail();
            break;
        case 'settle':
            pp_transaction_settle();
            break;
        default:
            pp_transaction_list();
    }
}

function pp_transaction_list()
{
    $filters = [
        'offset' => 0,
        'limit' => 20
    ];

    if(isset($_GET['from']) && !empty($_GET['from'])){
        $from = explode('/',$_GET['from']);
        $filters['fromDate'] = pp_jalali_to_gregorian(intval(pp_convert($from[0])),intval(pp_convert($from[1])),intval(pp_convert($from[2])),'-');
    }

    if(isset($_GET['to']) && !empty($_GET['to'])){
        $to = explode('/',$_GET['to']);
        $filters['toDate'] = pp_jalali_to_gregorian(intval(pp_convert($to[0])),intval(pp_convert($to[1])),intval(pp_convert($to[2])),'-');
    }

    if(isset($_GET['filter']) && !empty($_GET['filter'])){
        $filters['filter'] = explode(' ',(sanitize_text_field($_GET['filter'])));
    }

    if(isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] != -1){
        $filters['transactionType'] = intval($_GET['type']);
    }

    $api = new pp_Api();
    $res = $api->transactions($filters);
    require dirname(__FILE__). '/transaction.html.php';
}

function pp_transaction_detail()
{
    $api = new pp_Api();
    $transaction = $api->transaction($_GET['code'])->body;
    require dirname(__FILE__). '/transaction_detail.html.php';
}

function pp_transaction_settle()
{
    if(isset($_POST['pp_amount']) && !empty($_POST['pp_amount'])){
        global $price;
        if($_POST['pp_amount'] > $price){
            add_action( 'admin_notices_pp',function(){
                printf( '<div class="notice notice-error"><p>%1$s</p></div>','درخواست شما بیشتر از موجودی حسابتان است'); 
            });
        }else{
            $api = new pp_Api();
            $res = $api->withdraw($_POST['pp_amount']);
            if($res->code < 200 || $res->code >= 300){
                add_action( 'admin_notices_pp',function(){
                    printf( '<div class="notice notice-error"><p>%1$s</p></div>','در انجام تسویه حساب مشکلی پیش امده است. لطفا بعدا تلاش کنید'); 
                });
            }else{
                add_action( 'admin_notices_pp',function(){
                    printf( '<div class="notice notice-success"><p>%1$s</p></div>','درخواست تسویه حساب با کد پیگیری '.$res->body->code.' ایجاد شد.'); 
                });
            }
        }
    }
    require dirname(__FILE__). '/settle.html.php'; 
}




add_action('admin_head', 'pp_css');
function pp_css()
{
    ?>
    <link rel="stylesheet" href="<?= plugins_url() . '/payping/assets/css/persian-datepicker.css' ?>">
   <?php
}