<?php
session_start();
require 'DBConnection.php';

$fromUser = $_POST["fromUser"]??"";
$toUser = $_POST["toUser"]??"";
$message = $_POST["message"]??"";

$output = "";

$query = mysqli_query($connect,"INSERT INTO messages (FromUser,ToUser,Message) VALUES('$fromUser','$toUser','$message')");

if($query):
    $output .="";
else:
    $output .="Erro, Por favor tente novamente!";
endif;

echo $output;

?>