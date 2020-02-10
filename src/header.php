<?php
require dirname(__DIR__, 1) . '/vendor/autoload.php';
$db   = new \PDO('mysql:dbname=tippspiel;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bundesliga Tippspiel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
    <style>
    input{
        width:50px
    }
    input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
    </style>
</head>
<body>
    <div class="container">
    <?php
if ($auth->isLoggedIn()) {
?>
       Hallo <?php
    echo $_SESSION['auth_username'];
?> <a style="float:right" href="logout.php">ausloggen</a> | <a href="" data-toggle="modal" data-target="#myModal">Auswertung anzeigen</a>
        <?php
}
?>