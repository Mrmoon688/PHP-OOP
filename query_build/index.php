<?php

class Database
{
    private static $dbh = null;
    private static $res, $data, $count, $sql;
    public function __construct()
    { // Initialize database connection -$dbh
        self::$dbh = new PDO('mysql:host=localhost;dbname=php_project', 'root', '');
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function query($params = [])
    {
        //Initialize database connection -$res,$data
        self::$res = self::$dbh->prepare(self::$sql);
        self::$res->execute($params);
        return $this;
    }

    public function get()
    {
        $this->query(); // Call query method to execute the SQL statement
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        return self::$data;
    }
    public function getOne()
    {
        $this->query();
        self::$data = self::$res->fetch(PDO::FETCH_OBJ);
        return self::$data;
    }

    public function count()
    {
        $this->query();
        self::$count = self::$res->rowCount();
        return self::$count;
    }
    public static function table($table) /// static method can not use return$this;
    {

        $sql = "select * from $table";  //double quote 
        self::$sql = $sql;
        $db = new Database();
        $db->query();
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
        $this->query();
        return $this;
    }



    // DB::update('tablename', ['id' => 1], id = 1);
    public static function update($table, $data, $id)
    {
        //update users set name=?, age=?, location=? wher id=?;
        $db = new Database();
        $sql = "update $table set ";
        $value = "";
        $x = 1;
        foreach ($data as $k => $v) {
            $value .= "$k=?";
            if ($x < count($data)) {
                $value .= ",";
                $x++;
            }
        }
        $sql .= "$value where id=$id";
        self::$sql = $sql;
        $db->query(array_values($data));
        return Database::table($table)->where('id', $id)->getOne();
        // print_r($data);
        // echo $value;
        // echo count($data);
    }

    public static function delete($table, $id)
    {
        $sql = "delete from $table where id=$id";
        self::$sql = $sql;
        $db = new Database();
        $db->query();
        return true;
    }
}
// $db = new Database();
// $user = $db->query('select * from users')->get();
// echo $db->query('select * from users')->count();
// echo "<pre>";
// print_r($user);

// $user = Database::table('users')->orderBy('name', 'asc')->get();
// $user = Database::table('users')->where('id', '=', 3)->getOne();
// $user = Database::table('users')->getOne();
// $user = Database::update(
//     'users',
//     ['name' => 'update Name', 'age' => 25, 'location' => 'updatelocaiton'],
//     3
// );
// echo "<pre>";
// print_r($user);

if (Database::delete('users', 5)) {
    echo "Deleted";
}
