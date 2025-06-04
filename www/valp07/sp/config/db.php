<?php

const DB_HOSTNAME = 'localhost';
const DB_DATABASE = 'valp07';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';

const GLOBAL_CURRENCY = 'USD';

$db = new PDO(
    'mysql:host=' . DB_HOSTNAME . ';dbname=' . DB_DATABASE . ';charset=utf8mb4',
    DB_USERNAME,
    DB_PASSWORD
);
