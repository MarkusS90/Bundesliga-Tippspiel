<?php
require __DIR__ . '/vendor/autoload.php';
$db   = new \PDO('mysql:dbname=tippspiel;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);

try {
    $auth->login($_POST['email'], $_POST['password']);
    
    header('location: tippen.php?spieltag=1');
}
catch (\Delight\Auth\InvalidEmailException $e) {
    die('Wrong email address');
}
catch (\Delight\Auth\InvalidPasswordException $e) {
    die('Wrong password');
}
catch (\Delight\Auth\EmailNotVerifiedException $e) {
    die('Email not verified');
}
catch (\Delight\Auth\TooManyRequestsException $e) {
    die('Too many requests');
} 