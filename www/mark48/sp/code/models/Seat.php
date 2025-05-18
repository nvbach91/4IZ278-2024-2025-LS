<?php

/**
 * Seat model
 */
class Seat
{
    public $id;
    public $event_id;
    public $row_index;
    public $col_index;
    public $seat_category_id;
    public $category_name;
    public $price;
    public $status; // 'free', 'reserved', or 'sold'

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->event_id = $data['event_id'] ?? null;
            $this->row_index = $data['row_index'] ?? null;
            $this->col_index = $data['col_index'] ?? null;
            $this->seat_category_id = $data['seat_category_id'] ?? null;
            $this->category_name = $data['category_name'] ?? null;
            $this->price = $data['price'] ?? null;
            $this->status = $data['status'] ?? 'free';
        }
    }
}

/**
 * Seat Category model
 */
class SeatCategory
{
    public $id;
    public $name;
    public $price;
    public $version;

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->price = $data['price'] ?? null;
            $this->version = $data['version'] ?? 1;
        }
    }
}
