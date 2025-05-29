<?php
class Ant
{
    public static $ant = 'ant';
    public static function showAnimal()
    {
        echo "The Ant method.";
    }
}

class some
{
    public function __construct()
    {
        echo Ant::$ant; // static property ကို access လုပ်တဲ့နည်းလမ်း
        Ant::showAnimal(); // static method ကို access လုပ်တဲ့နည်းလမ်း
    }
}

$s = new Some();


// echo Ant::$ant;
// echo Ant::showAnimal();   // new obj ဆောက်စရာမလို class ကိုတန်းခေါ်ပြီး scope resolution operator နဲ့ method ကို ခေါ်လိုက်ရင်ရပြီ
