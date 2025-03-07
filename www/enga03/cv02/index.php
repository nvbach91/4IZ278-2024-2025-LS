<?php
/**
 * Amelie Engelmaierová
 */
require_once __DIR__ . '/classes/Person.php';

$person0 = new Person(
    ["Amelie", "Engelmaierová"],
    date_create("2004-06-30"),
    ["Computer Academy teacher", "Freelance Web Dev"],
    "ikoronka s.r.o.",
    "Chemická",
    "420",
    "69",
    "Prague",
    123_456_789,
    "email@email.cz",
    "https://www.ikoronka.com",
    true,
    "ikoronka.svg"
);

$person1 = new Person(
    ["John", "Doe"],
    date_create("1990-01-01"),
    ["Web Developer", "Designer"],
    "Doe Inc.",
    "Main Street",
    "123",
    "456",
    "New York",
    987_654_321,
    "john@doe.com",
    "https://www.youtube.com/watch?v=q-Y0bnx6Ndw",
    false,
    "person1.svg"
);

$person2 = new Person(
    ["Jane", "Doe"],
    date_create("1995-01-01"),
    ["Cleaning Lady"],
    "Doe Inc.",
    "Other Street",
    "321",
    "654",
    "New York",
    123_456_789,
    "jane@doe.com",
    "https://www.youtube.com/watch?v=q-Y0bnx6Ndw",
    true,
    "person2.svg"
);

$people = [$person0, $person1, $person2];

include __DIR__ . '/includes/head.php'; 
include __DIR__ . '/components/BusinessCard.php';
include __DIR__ . '/includes/foot.php'; 
?>