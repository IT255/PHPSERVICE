<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: POST');
include("functions.php");

if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['password'])){
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
echo register($username,$password,$firstname,$lastname);
}
 ?>
