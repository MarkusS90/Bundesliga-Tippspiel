<?php
require __DIR__ . '/vendor/autoload.php';
$db = new \PDO('mysql:dbname=tippspiel;host=localhost;charset=utf8mb4', 'root', '');
$auth = new \Delight\Auth\Auth($db);

try {
    $userId = $auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {
        header('location: tippen.php?spieltag=1'');
    });
}

}
catch (\Delight\Auth\InvalidEmailException $e) {
    die('Invalid email address');
}
catch (\Delight\Auth\InvalidPasswordException $e) {
    die('Invalid password');
}
catch (\Delight\Auth\UserAlreadyExistsException $e) {
    die('User already exists');
}
catch (\Delight\Auth\TooManyRequestsException $e) {
    die('Too many requests');
}