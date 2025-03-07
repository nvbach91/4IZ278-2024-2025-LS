<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        a {
            color: white;
        }
        .wrapper {
            display: flex;
            flex-direction: row;
            width: 90%;
            flex-wrap: wrap;
            margin-left: auto;
            margin-right: auto;
            justify-content: space-around;
        }
        .wrapper > div {
            width: 40%;
            margin: 1em;
            padding: 1em;
            background-color: darkslategray;
        }
        .front {
            display: flex;
            flex-direction: column;
            height: 12em;
        }
        .horizontal {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .horizontal > div {
            width: 45%;
        }
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar img {
            max-width: 80%;
        }
        .back {
            height: 12em;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .columns {
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        .back .col {
            width: 45%;
        }
        .front , .back {
            color: white;
            font-size: large;
            font-family: Arial, Helvetica, sans-serif;
        }
        .otv {
            color: green;
        }
    </style>
</head>
<body>