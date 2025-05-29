<?php

class Database
{
    const HOST = "localhost-172.0.0.1"; // constant property - const နဲ့ variable ဆောက်ထားရင် $ ထည့်စရာမလိုဘူး
}
// echo Database::HOST; // constant property ကို access လုပ်တဲ့နည်းလမ်း (: :) scope resolution operator နဲ့ access လုပ်တယ်

class Host
{
    public function hostConnect()
    {
        echo Database::HOST;  // class name::constant variable
    }
}

$h = new Host();
$h->hostConnect();
