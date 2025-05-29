<?php

// abstract class ဆိုရင် abstract method တွေကို ရေးထားရမယ်။
abstract class Home
{
    public $name = "Saw Saw";
    abstract public function items();  // abstract method ပါ 
    public function __construct()    // constructor methd ပါ
    {
        echo "Welcom to " . $this->name . ' house '; // abstract class မှာ constructor ရေးထားရင် new obj ဆောက်တဲ့အခါမှာ constructor ကို ခေါ်သုံးနိုင်တယ်။
    }
}

class building extends Home
{
    public function items()
    {
        echo $this->name . ' has house in yangon';
    }
}

$house =  new building();
$house->items();
