<?php
class Good
{

    public $good_id;
    public $name;
    public $price;
    public $description;
    public $img;
    public $timestamp;
    public $locked_by;
    public $locked_at;


    public function __construct($good_id, $name, $price, $description, $img, $timestamp = null, $locked_by = null, $locked_at = null)
    {
        $this->good_id = $good_id;
        $this->name = $name;
        $this->price = $price;
        $this->description = $description;
        $this->img = $img;
        $this->timestamp = $timestamp;
        $this->locked_by = $locked_by;
        $this->locked_at = $locked_at;
    }
}
