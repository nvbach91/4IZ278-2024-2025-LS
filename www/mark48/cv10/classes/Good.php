<?php
class Good
{

    public $good_id;
    public $name;
    public $price;
    public $description;
    public $img;


    public function __construct($good_id, $name, $price, $description, $img)
    {
        $this->good_id = $good_id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->img = $img;
    }
}
