<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vizitka</title>
  <style>
    body {
      margin: 20px;
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    .cards {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    .card {
      width: 300px;
      height: 150px;
      box-sizing: border-box;
      border: 4px solid #ff8c00;
      border-radius: 8px;
      background-color: #fff7e6;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 10px;
    }
    .card img {
      width: 50px;
      height: 50px;
      margin-bottom: 5px;
      border-radius: 50%;
      object-fit: cover;
    }
    .card h1 {
      margin: 0;
      font-size: 16px;
      color: #333;
      line-height: 1.2;
    }
    .card p {
      margin: 3px 0;
      font-size: 13px;
      line-height: 1.2;
      color: #333;
    }
    a {
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
