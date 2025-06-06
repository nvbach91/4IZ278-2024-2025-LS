<?php

require_once __DIR__ . '/Ticket.php';

/**
 * Order model
 */
class Order
{
    public $order_id;
    public $user_id;
    public $user_name;
    public $order_date;
    public $ticket_count;
    public $total_price;
    public $payment_status; // Derived from payments table

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->order_id = $data['order_id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
            $this->user_name = $data['user_name'] ?? null;
            $this->order_date = $data['order_date'] ?? null;
            $this->ticket_count = $data['ticket_count'] ?? null;
            $this->total_price = $data['total_price'] ?? null;
            $this->payment_status = $data['payment_status'] ?? null;
        }
    }
}
