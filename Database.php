<?php
class Database
{
    // properties  ရှိမယ်
    public $host = "localhost property ပါ";

    // methods ရှိမယ်
    public function connection()
    {
        return $this->host;  // localhost property ပါ
    }

    public function main($table) //default value ထည့်ထားလို့ရတယ်
    {
        return $table; // table ရဲ့ data တွေကို return ပြန်ပေးမယ်
    }
}

class User extends Database
{
    public function details()
    {
        echo $this->connection();
    }
}

$db = new User();
$db->details(); // method ကို ခေါ်လိုက်တယ်
// $db = new Database();  // new obj ဆောက်လိုက်တယ်
// echo $db->main('users'); // arg မှာ ဘာမှ မထည့်လိုက်ရင် default value ထုတ်ပြမှာပါ

// echo $db->connection(); // localhost property ပါ 
// echo $db->host; // localhost property ပါ
