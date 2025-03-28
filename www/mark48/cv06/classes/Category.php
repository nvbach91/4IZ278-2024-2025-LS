<?php
class Category
{
    public $id;
    public $name;
    public $number;


    public function __construct($id, $name, $number)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
    }
}
