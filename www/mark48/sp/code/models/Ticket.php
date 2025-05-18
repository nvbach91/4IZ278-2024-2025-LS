<?php


/**
 * Ticket model
 */
class Ticket
{
    public $id;
    public $order_id;
    public $seat_id;
    public $row_index;
    public $col_index;
    public $category_name;
    public $price;
    public $event_title;
    public $event_id;
    public $start_datetime;
    public $location;

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->order_id = $data['order_id'] ?? null;
            $this->seat_id = $data['seat_id'] ?? null;
            $this->row_index = $data['row_index'] ?? null;
            $this->col_index = $data['col_index'] ?? null;
            $this->category_name = $data['category_name'] ?? null;
            $this->price = $data['price'] ?? null;
            $this->event_title = $data['event_title'] ?? null;
            $this->event_id = $data['event_id'] ?? null;
            $this->start_datetime = $data['start_datetime'] ?? null;
            $this->location = $data['location'] ?? null;
        }
    }
}
