<?php
require __DIR__ . '/vendor/autoload.php';
$db   = new \PDO('mysql:dbname=tippspiel;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);
$auth->logOut();
header('location: index.php'); 