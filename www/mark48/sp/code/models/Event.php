<?php

/**
 * Event model
 */
class Event
{
    public $id;
    public $title;
    public $description;
    public $location;
    public $start_datetime;
    public $end_datetime;
    public $event_type_id;
    public $event_type_name;
    public $created_by;
    public $has_seating_plan;
    public $version;

    /**
     * Constructor
     */
    public function __construct($data = null)
    {
        if ($data) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? null;
            $this->description = $data['description'] ?? null;
            $this->location = $data['location'] ?? null;
            $this->start_datetime = $data['start_datetime'] ?? null;
            $this->end_datetime = $data['end_datetime'] ?? null;
            $this->event_type_id = $data['event_type_id'] ?? null;
            $this->event_type_name = $data['event_type_name'] ?? null;
            $this->created_by = $data['created_by'] ?? null;
            $this->has_seating_plan = $data['has_seating_plan'] ?? null;
            $this->version = $data['version'] ?? 1;
        }
    }
}
