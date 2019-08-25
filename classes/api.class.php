<?php
class pp_Response{
    public function __construct($res){
        $this->code = $res['response']['code'];
        $this->body = json_decode($res['body']);
    }

    public $code;
    public $body;
}

class pp_Api{
    private $token = '';
    private $base_url = "https://api.payping.ir/v1/";

    public function __construct($token = false){
        if(!$token){
            $this->token = get_option('pp_token');
        }else{
            $this->token = $token;
        }
    }

    private function call($method,$path,$params=[]){
        $args = array(
            'timeout' => 30,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json'
            )
        );
        switch($method){
            case 'get':
                $result = wp_remote_get($this->base_url.$path.'?'.http_build_query($params),$args);
            break;
            case 'post':
                $args['body'] = $params;
                $result = wp_remote_post($this->base_url.$path,$args);
            break;
        }
        return $result;
    }

    public function transactions(array $params){
        $res  = $this->call('post','report/TransactionReport',json_encode($params));
        return new pp_Response($res);
    }

    public function transactionsCount(array $params){
        $res  = $this->call('post','report/TransactionReportCount',json_encode($params));
        return new pp_Response($res);
    }

    public function transaction($code){
        $res = $this->call('get','report/'.$code);
        return new pp_Response($res);
    }

    public function balance(){
        $res = $this->call('get','report/Balance');
        return new pp_Response($res);
    }

    public function unVerifiedPayment(){
        $res = $this->call('get','pay/UnVerifiedPayment');
        return new pp_Response($res);
    }

    public function withdraw($amount){
        $res = $this->call('post','withdraw/'.$amount);
        return new pp_Response($res);
    }
}