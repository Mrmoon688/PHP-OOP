<?php

class Human
{
    private $name = "Saw Saw", $age = 20;
    public function setName()
    {
        $this->name;
        return $this;
    }

    public function setAge()
    {
        $this->age;
        return $this;
    }

    public function details()
    {
        echo $this->name . $this->age;
    }
}

$p =  new Human();
$p->setName()->setAge()->details();
