<?php
class SimpleClass
{
    public $name;
    public $age;
    function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }
    function great()
    {
        return "Hello, my name is " . $this->name . " and I am " . $this->age . " years old.";
    }
}
$person1 = new SimpleClass("Alice", 30);
echo $person1->great();
