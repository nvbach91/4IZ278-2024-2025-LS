<?php

require_once 'DbPdo.php';
require_once 'classes/Slide.php';

class SlideDb
{
    private $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }


    public function find()
    {
        $sql = "SELECT * FROM cv06_slides";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $slides = [];


        foreach ($rows as $row) {
            $slides[] = new Slide(
                $row['slide_id'],
                $row['title'],
                $row['img']
            );
        }

        return $slides;
    }
}
