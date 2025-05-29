<?php
class Test
{
    public function __construct()
    {
        echo "construct method working";
    }

    public function show()
    {
        echo "show method working";
    }
    public function __destruct()
    {
        echo "Destruct method working";
    }
}

$greeting = new Test(); // __construct() method ကို ခေါ်လိုက်တယ်
$greeting->show(); // show() method ကို ခေါ်လိုက်တယ်

// $greeting->__construct(); // __construct() method ကို ထပ်ခေါ်လိုက်တယ်