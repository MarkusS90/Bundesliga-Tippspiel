<?php
require __DIR__ . '/vendor/autoload.php';
$pdo  = new PDO('mysql:host=localhost;dbname=tippspiel', 'root', '');
$auth = new \Delight\Auth\Auth($pdo);


$statement = $pdo->prepare("REPLACE INTO tipps (userid, spielid, tore_1, tore_2) VALUES (?, ?, ?, ?)");
$statement->execute(array(
    $auth->getUserId(),
    $_POST['spielid'],
    $_POST['tore1'],
    $_POST['tore2']
));

header('location: tippen.php?spieltag=' . $_GET['spieltag']);