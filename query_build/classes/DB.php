<?php
class DB
{
    private static $dbh = null;        // database handler
    private static $res, $data, $count, $sql;
    public function __construct()
    {
        self::$dbh = new PDO('mysql:host=localhost;dbname=php_project', 'root', '');
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "connected to database";
    }
    public function query($params = [])
    {
        self::$res = self::$dbh->prepare(self::$sql);
        self::$res->execute($params);
        // echo self::$count . " record(s) found <br>";
        return $this;
    }
    public function get()
    {
        $this->query();
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

    public static function table($table)
    {
        $sql = "SELECT * FROM $table";
        self::$sql = $sql;
        $db = new DB();
        // $db->query();
        return $db;
    }

    public function orderBy($col, $value)
    {
        self::$sql .= " ORDER By $col $value";
        $this->query();
        return $this;
    }
    public function where($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            self::$sql .= " where $col='$operator'";
        } else {
            self::$sql .= " where $col $operator '$value'";
        }
        // echo self::$sql;
        return $this;
    }
    public function andWhere($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            self::$sql .= " and $col='$operator'";
        } else {
            self::$sql .= " and $col $operator '$value'";
        }
        echo self::$sql;
        return $this;
    }
    public function orWhere($col, $operator, $value = '')
    {
        if (func_num_args() == 2) {
            self::$sql .= " or $col='$operator'";
        } else {
            self::$sql .= " or $col $operator '$value'";
        }
        return $this;
    }

    public static function create($table, $data)
    {
        $db = new DB();
        $str_col = implode(',', array_keys($data));
        $v = "";
        $x = 1;
        foreach ($data as $d) {
            $v .= "?";
            if ($x < count($data)) {
                $v .= ",";
                $x++;
            }
        }
        // echo $v;
        // print_r($data);
        $sql = "insert into $table($str_col) values($v)";
        self::$sql = $sql;
        $value = array_values($data);
        $db->query($value);
        $id = self::$dbh->lastInsertId();
        return DB::table($table)->where('id', $id)->getOne();
    }

    public static function update($table, $data, $id)
    {
        //name=? age=? and location=?
        $db = new DB();
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
        // echo $sql;
        // die();
        $db->query(array_values($data));
        return DB::table($table)->where('id', $id)->getOne();
    }

    public static function delete($table, $id)
    {
        $sql = "delete from $table where id=$id ";
        self::$sql = $sql;
        $db = new DB();
        $db->query();
        return true;
    }
    public static function raw($sql)
    {
        $db = new DB();
        self::$sql = $sql;
        // print_r($db->query()->get());
        return $db;
    }
    public function paginate($records_per_page)
    {
        if (isset($_GET['page'])) {
            $page_no = $_GET['page'];
        } else {
            $page_no = $_GET['page'] = 1;
        }
        // if (!isset($_GET['page'])) {
        //     $page_no = 1;
        // }
        if (isset($_GET['page']) and $_GET['page'] < 1) {
            $page_no = 1;
        }
        $this->query();
        $count = self::$res->rowCount();

        $index = ($page_no - 1) * $records_per_page;
        self::$sql .= " LIMIT $index, $records_per_page";
        $this->query();
        self::$data = self::$res->fetchAll(PDO::FETCH_OBJ);
        $prev_no = $page_no - 1;
        $next_no = $page_no + 1;
        $prev_page = "?page=$prev_no";
        $next_page = "?page=$next_no";
        // print_r(self::$data);
        $data =  [
            'data' => self::$data,
            'total' => $count,
            'next_page' => $next_page,
            'prev_page' => $prev_page,
        ];
        return $data;
    }
}

// $user = DB::raw("SELECT * FROM users")->paginate(5);
// echo "<pre>";
// print_r($user);

//pagination
// $user = DB::table('users')->orderBy('id', 'desc')->paginate(5);
// $user = DB::table('users')->orderBy('id', 'desc')->paginate(5);

// foreach ($user['data'] as $u) {
//     echo "<pre>";
//     print_r($u->id . " " . $u->name);
// }

// [
//     'data' => [],
//     'total' => 0,
//     'next_page' => 5,
//     'prev_page' => 5,
// ]

// $user = DB::table('users')->where('name', 'like', '%ser%')->orWhere("location", "shan")->get();
// $user =DB::table('users')->orderBy('name','asc')->get();
// $user =DB::table('users')->where('id',2 )->get();
// $user =DB::table('users')->where('id',1)->getOne();
// $user = DB::table('users')->where('name', 'like', '%ser%')->orWhere("location", "shan")->get();
// echo "
// <pre>";
// print_r($user);
// $db = new DB();
// echo "<pre>";
// $users = $db->query("SELECT * FROM users")->get();
// echo $db->query("SELECT * FROM users")->update();
// print_r($users);

// $user = DB::create(
//     'users',
//     [
//         'name' => 'Apple',
//         'age' => '30',
//         'location' => 'Yangon',

//     ]
// );
// print_r($user);

// $user = DB::update('users', [
//     'name' => 'Apple',
//     'age' => '30',
//     'location' => 'Yangon',
// ], 3);
// print_r($user);
// if (DB::delete('users',  29)) {
//     echo "deleted";
// };
// print_r($user);