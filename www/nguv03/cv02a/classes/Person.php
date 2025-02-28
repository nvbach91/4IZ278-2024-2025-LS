<?php

class Person {
    public function __construct(
        public $name,
        public $email,
        public $phone,
        public $address,
        public $bankCode,
        public $accountNumber,
    ) {}

    public function getFullBankAccountNumber() {
        return "$this->accountNumber / $this->bankCode";
    }
}

?>