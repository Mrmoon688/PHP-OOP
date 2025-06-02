<?php

class Database
{
    private static $dbh = null;
    private static $res, $data, $count, $sql;
    public function __construct()
    { // Initialize database connection -$dbh
        self::$dbh = new PDO('mysql:host=localhost;dbname=php_project', 'root', '');
    }
    public function query($sql)
    {
        //Initialize database connection -$res,$data
        self::$res = self::$dbh->prepare($sql);
        self::$res->execute();
        self::$count = self::$res->rowCount();
        return $this;
    }

    public function get()
    {
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        return self::$data;
    }

    public function count()
    {
        return self::$count;
    }
    public static function table($table) /// static method can not use return$this;
    {
        $sql = "select * from $table";  //double quote 
        self::$sql = $sql;
        $db = new Database();
        $db->query(self::$sql);
        return $db;
    }
    public function orderBy($col, $value)
    {
        self::$sql .= " order by $col $value"; //.= no space between . and =
        $this->query();
        return $this; // return $this to allow method chaining
    }
    public function where($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            self::$sql .= " where $col=$operator";
        } else {
            self::$sql .= " where $col $operator $value";
        }
        $this->query(self::$sql);
        return $this;
    }

    public function getOne()
    {
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }
}
// $db = new Database();
// $user = $db->query('select * from users')->get();
// echo $db->query('select * from users')->count();
// echo "<pre>";
// print_r($user);

// $user = Database::table('users')->orderBy('name', 'asc')->get();
// $user = Database::table('users')->where('id', '=', 3)->getOne();
$user = Database::table('users')->getOne();
echo "<pre>";
print_r($user);
