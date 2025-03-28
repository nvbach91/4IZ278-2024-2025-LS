<?php

class Slide
{
    public $id;
    public $title;
    public $img;

    public function __construct($id, $title, $img)
    {
        $this->id = $id;
        $this->title = $title;
        $this->img = $img;
    }
}
