<?php
class Tester
{
    //access modifiers
    //1.public modifier
    // protected $name = "saw saw";
    protected $age = 22;
    public function showAge()
    {
        echo $this->age;
    }
    //2.protected modifier
    //3.private modifier

}
$t = new Tester();
$t->showAge();


// class newTest extends Tester
// {
//     public function showName()
//     {
//         $newName = new Tester();
//         echo $newName->name;
//     }
// }

// $t = new newTest();
// $t->showName();
