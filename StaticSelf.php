<?php
class Some
{
    public $name = 'boby';
    public static function showName()
    {
        // echo $this->$name; // error $this-> နဲ့‌ ခေါ်မရပါဘူး .static method :: ခေါ်ပါ
        // echo self::$name; // static property ကို access လုပ်တဲ့နည်းလမ်း
        // echo Some::$name;
        $n = new Some();
        echo $n->name; // static method မှာ static property ကို access လုပ်တဲ့နည်းလမ်းမဟုတ်ဘူး။ ဒါကြောင့် new obj ဆောက်ပြီး access လုပ်ရမယ်။
    }
}
Some::showName();
// $n = new Some();
// $n->showName();
