<?php 
/**
 * Mysqli 基类
 * @author objui@qq.com
 * @version v1.0
 */
namespace OBJUI;

class Mysql
{
    private $conn;  //连接资源
    private static $config = [
        'host'      => 'localhost', 
        'port'      => '3306',
        'user'      => 'root',
        'pass'      => 'root',
        'dbname'    => 'test',      //数据库名
        'charset'   => 'utf8mb4'    //编码
    ];
    
    /**
     * 构造方法
     * @param array $config
     */
    public function __construct(array $config = [])
    {
         
        self::$config = array_merge(self::$config, array_change_key_case($config));
       
        $this->connect();
        $this->setCharset();
        $this->setDbname();
    }

    /**
     * 连接数据库
     * @return \OBJUI\Mysql
     */
    public function connect()
    {
        try {
            if (empty($this->conn)) {
                $this->conn =  new \PDO("mysql:host=" . self::$config['host'] . ";dbname=" . self::$config['dbname'], self::$config['user'], self::$config['pass']);
            }
        } catch (\PDOException $e) {
            die("could not connect to the database:\n" .$e->getMessage());
        }
    }
    
    /**
     * 执行语句
     * @param string $sql
     */
    public function query(string $sql = '')
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_CLASS);
        } catch (\PDOException $e) {
            die("could not connect to the database:\n" .$e->getMessage());
        }
    }
    
    public function getInsertId()
    {
        $sql = "select LAST_INSERT_ID() as id";
        $row = $this->query($sql);
        $id = $row[0]->id;
        return intval($id);
    }
    
    /**
     * 设置编码
     */
    public function setCharset()
    {
        $charset = self::$config['charset'];
        $this->conn->exec("set names '{$charset}'");
    }
    
    /**
     * 选择数据库
     */
    public function setDbname()
    {
        $bdname = self::$config['dbname'];
        $this->conn->exec("use {$bdname}");
    }
      
    
    /**
     * 关闭数据库
     */
    public function close()
    {
        $this->conn = null;
    }
    
    /**
     * 魔术方法
     * @param string $name
     * @param array $arguments
     * @return array|string|object
     */
    public function __call(string $name, array $arguments){
        switch(count($arguments)){
            case 1:
                return $this->conn->$name($arguments[0]);
                break;
            case 2:
                return $this->conn->$name($arguments[0],$arguments[1]);
                break;
            case 3:
                return $this->conn->$name($arguments[0],$arguments[1],$arguments[2]);
                break;
            default:
                return $this->conn->$name();
        }
    }
    
    /**
     * 析构方法
     */
    public function __destruct()
    {
        $this->close();
    }
}