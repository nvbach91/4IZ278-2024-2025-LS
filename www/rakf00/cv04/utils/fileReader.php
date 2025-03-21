<?php

const FILE_PATH = __DIR__ . "/users.db";
function fetchUsers(): array
{
    $users = [];
    $lines = file(FILE_PATH);
    foreach ($lines as $line) {
        $data = explode(";", $line);
        $users[$data[0]] = [
            "password" => $data[1],
            "name"     => $data[2],
        ];
    }
    return $users;
}

function fetchUser(string $userEmail)
{
    $users = fetchUsers();

    return $users[$userEmail] ?? null;
}

function writeNewLine(string $newLine): void
{
    $openFile = fopen(FILE_PATH, "a");
    fwrite($openFile, $newLine.PHP_EOL);
    fclose($openFile);
}


