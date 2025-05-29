<?php
// interface - public နဲ့ကြေညာတယ်..သို့သော် abstract method တွေဖြစ်ပါတယ်
interface Animal
{
    //public 
    //no property
    // all method in interface must be public and abstract
    // public $name="dog"; // Error: Interfaces cannot have properties
    public function eat();
    public function makeSound();
}

class Dog implements Animal
{
    public function eat()
    {
        echo "the dog is eating";
    }
    public function makeSound()
    {
        echo "woof woof";
    }
}

$d = new Dog();
$d->eat(); // Output: the dog is eating
$d->makeSound(); // Output: woof woof