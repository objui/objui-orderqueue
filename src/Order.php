<?php 
/**
 * 订单类
 * @author objui@qq.com
 * @version v1.0
 */
namespace OBJUI;

class Order
{
    protected $redis;
    protected  $mysql;
    
    public function __construct()
    {
        $this->redis = Redis::getInstance(Config::$config['redis']);
        $this->mysql = new Mysql(Config::$config['mysqli']);
    }
    
    /**
     * 将库存存入Redis
     */
    public function setStock()
    {
        try{
            $proid = 1;
            $sql = "SELECT * FROM obj_goods WHERE id={$proid}";
            $row = $this->mysql->query($sql);
            $store=$row[0]->stocks;
            $info = json_encode($row[0]);
            #清空列表
            $this->redis->LREM('goods_store',0,0);
            $this->redis->LPOP('goods_store');
            $res=$this->redis->llen('goods_store');
            $count=$store-$res;
            for($i=0;$i<$count;$i++){
                $this->redis->lpush('goods_store',$info);
            }
            return json_encode(['code'=>200, 'msg'=>'操作成功']);
        } catch (\Throwable $e) {
            return json_encode(['code'=>$e->getCode(), 'msg'=>$e->getMessage()]);
        } catch (\Error $e) {
            return json_encode(['code'=>$e->getCode(), 'msg'=>$e->getTrace()]);
        }
    }
    
    /**
     * 购买
     */
    public function buy()
    {
        $proinfo =$this->redis->lpop('goods_store');
        if(!$proinfo){
            return json_encode(['code'=>205, 'msg'=>'您来晚了，商品已售完']);
        }
        $info = json_decode($proinfo, 1);
        $out_order_no = $this->build_order_no();
        $insert_data = [
            'out_order_no' => $out_order_no,
            'uid'           => 0,
            'price'         => $info['price'],
            'real_pay'      => 0,
            'buy_time'      => time()
        ];
        foreach ($insert_data as $key=>$val) {
            $$key = $val;
        }
        $insertSql = "INSERT INTO `obj_order` (out_order_no, uid, price, real_pay,buy_time) values ($out_order_no, $uid, $price, $real_pay, $buy_time)";
        $this->mysql->query($insertSql);
        $insertId = $this->mysql->getInsertId();
        if ($insertId > 0) {
            return json_encode(['code'=>200, 'msg'=>'恭喜您，下单成功，请在2个小时内完成支付，否则订单自动取消']);
        } else {
            return json_encode(['code'=>10001, 'msg'=>'系统繁忙，请稍后再试~' ]);
        }
    }
    
    /**
     * 结算
     */
    public function pay()
    {
        
    }
    
    /**
     * 生成24位订单号
     * @return string
     */
    public function build_order_no(){
        return date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 10);
    }
}