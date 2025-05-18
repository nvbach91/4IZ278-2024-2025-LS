<?php

const DB_HOSTNAME = '';
const DB_DATABASE = '';
const DB_USERNAME = '';
const DB_PASSWORD = '';

const GLOBAL_CURRENCY = 'USD';

$db = new PDO(
    'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE . ';charset=utf8mb4',
    DB_USERNAME,
    DB_PASSWORD
);
?>