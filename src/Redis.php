<?php 
/**
 * Redis封装
 * @author objui@qq.com
 * @version v1.0
 */
namespace OBJUI;

class Redis{
    private $redis;
    private static $_instance = null;
    private static $config = [
        'scheme'   => 'tcp',
        'host'     => '127.0.0.1',
        'port'     => 6379,
        'out_time' => 360
    ];
    
    /**
     * @desc 单例模式实例化
     * @return \OBJUI\Redis
     */
    public static  function getInstance(array $config = [])
    {
        if (empty(self::$_instance)) {
            self::$_instance = new self($config);
        }
        return  self::$_instance;
    }
    
    public function __construct(array $config = [])
    {
        self::$config = array_merge(self::$config, array_change_key_case($config));
        $client = $this->redis =  new \Predis\Client(self::$config, ['cluster' => 'redis']);
        if($client === false){
            throw new \Exception('redis connect error');
        }
    }
    
    public function __call($name,$arguments){
        switch(count($arguments)){
            case 1:
                return $this->redis->$name($arguments[0]);
                break;
            case 2:
                return $this->redis->$name($arguments[0],$arguments[1]);
                break;
            case 3:
                return $this->redis->$name($arguments[0],$arguments[1],$arguments[2]);
                break;
            default:
                return $this->redis->$name();
        }
    }
    
}