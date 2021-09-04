<?php

require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('https://php-firebase-3aa97-default-rtdb.firebaseio.com/');

$dataBase = $factory->createDatabase();

$connect = mysqli_connect("localhost","root","123456","chat-php");


?>