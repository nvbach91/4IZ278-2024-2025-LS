<?php
class Product
{
    public $id;
    public $name;
    public $price;
    public $imageUrl;
    public $categoryId;


    public function __construct($id, $name, $price, $imageUrl, $categoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->categoryId = $categoryId;
    }
}
