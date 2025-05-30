<?php
class Father
{
    public function fatherName()
    {
        echo " My Father is Ti war <br>";
    }
}

trait Mother    // သုံးမဲ့ class ထဲမှာ use လုပ်ရမယ်
{
    public function motherName()
    {
        echo "My Mother is Naw Paw";
    }
}

class Child extends Father
{
    //
    use Mother;          // trait Mother ကို သုံးဖို့ use လုပ်ထားတယ်
    public function __construct()
    {
        $this->fatherName();
        $this->motherName();
    }
}

$family = new Child();    // result output - My Father is Ti war // My Mother is Naw Paw
// $family->fatherName();
// $family->motherName();
