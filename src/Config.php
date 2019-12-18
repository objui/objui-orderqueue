<?php 
namespace OBJUI;

class Config
{
     
    public static $config = [
        'redis' => [
            'scheme'   => 'tcp',
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'out_time' => 360
        ],
        'mysqli' => [
            'host'      => 'localhost',
            'port'      => '3306',
            'user'      => 'user_order',
            'pass'      => '123456',
            'dbname'    => 'obj_order',     //数据库名
            'charset'   => 'utf8mb4'        //编码
        ]
    ];
}
