<?php 
require '../vendor/autoload.php';

use OBJUI\Redis;
$redis = Redis::getInstance();


//生成唯一订单号
function build_order_no(){
    return date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 10);
}

#存库存
/*
$store=1000;
$res=$redis->llen('goods_store');
$count=$store-$res;
for($i=0;$i<$count;$i++){
    $redis->lpush('goods_store',1);
}
echo $redis->llen('goods_store');
*/

#开抢
$len =$redis->lpop('goods_store');
//echo $redis->llen('goods_store');
if(!$len){
    echo '抢光了';
    exit;
}

$redis->lpush('order:1',build_order_no());
echo '<pre>';
print_r($redis->LRANGE('order:1', 0, -1));
#并发测试
//ab -r -n 6000 -c 5000  http://192.168.1.198/big/index.php