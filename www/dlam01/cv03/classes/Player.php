<?php
class Player
{
    public function __construct(
        public $fullName,
        public $gender,
        public $phoneNumber,
        public $email,
        public $avatar
    ) {}
}
