<?php
// pdo
// pro static
class Database
{
    private static $pdo;  //pdo connect to database
    public function __construct()
    {
        self::$pdo = new PDO('mysql:host=localhost;dbname=php_project', 'root', '');
        echo "connected with database";
    }
    public function getPdo()
    {
        if (!self::$pdo) {
            new Database();
        }
        return $this;
    }

    public function getAll($table)
    {
        $sql = "SELECT * FROM $table";
        $result = self::$pdo->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOne()
    {
        $sql = "select  * from users where id=1";
        $result = self::$pdo->prepare($sql);
        $result->execute();
        return $result->fetch(PDO::FETCH_OBJ);
    }
}

$d = new Database();
echo "<pre>";
// $user= $d->getPdo()->getAll("users");
$user = $d->getPdo()->getOne();
print_r($user);
