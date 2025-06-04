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

        $sql = "SELECT * FROM $table";  //double quote 
        self::$sql = $sql;
        $db = new Database();
        // $db->query();
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
            $val = is_numeric($operator) ? $operator : "'$operator'";
            self::$sql .= " WHERE $col = $val";
        } else {
            $val = is_numeric($value) ? $value : "'$value'";
            self::$sql .= " WHERE $col $operator $val";
        }
        return $this;
    }


    public function andWhere($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            self::$sql .= " and $col=$operator";
        } else {
            self::$sql .= " and $col $operator $value";
        }
        // $this->query();
        return $this;
    }
    public function orWhere($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            $val = is_numeric($operator) ? $operator : "'$operator'";
            self::$sql .= " OR $col = $val";
        } else {
            $val = is_numeric($value) ? $value : "'$value'";
            self::$sql .= " OR $col $operator $val";
        }
        return $this;
    }

    public static function create($table, $data)
    {
        $db = new Database();
        $str_col = implode(",", array_keys($data));
        $v = "";
        $x = 1;
        foreach ($data as $d) {
            $v .= "?";
            if ($x < count($data)) {
                $v .= ",";
                $x++;
            }
        }
        $sql = "insert into $table ($str_col) values ($v)";
        self::$sql = $sql;
        $value = array_values($data);
        $db->query($value);
        $id = self::$dbh->lastInsertId();
        return Database::table($table)->where('id', $id)->getOne();
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
    public function paginate($record_per_page)
    {
        if (isset($_GET['page'])) {
            $page_no = $_GET['page'];
        }
        if (!isset($_GET['page'])) {
            $page_no = 1;
        }
        if (isset($_GET['page']) and $_GET['page'] < 1) {
            $page_no = 1;
        }
        $this->query();
        $count = self::$res->rowCount();
        echo $count;
        // 0,5 page 1
        //5,5 page 2
        //10,5 page 3
        $index = ($page_no - 1) * $record_per_page;
        // SELECT * FROM users LIMIT 0,5
        self::$sql .= " LIMIT $index,$record_per_page";
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        echo "<pre>";
        var_dump(self::$data);
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

// if (Database::delete('users', 5)) {
//     echo "Deleted";
// }

// $user = Database::table('users')->where('name', 'like', '%s%')->orWhere("location", 'yangon')->get();
// echo "<pre>";
// print_r($user);

// Database::table('users')->orderBy('id', 'desc')->paginate(5);
Database::table('users')->where('name', 'like', '%u%')->paginate(10);
