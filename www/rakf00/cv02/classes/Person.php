<?php

namespace classes;
class Person
{
    public function __construct(
        public $name,
        public $email,
        public $phone,
        public $address,
        public $bankCode,
        public $accountNumber,

    )
    {
    }

    public function getBankAccount(){
        return "$this->accountNumber / $this->bankCode";
    }
}

?>