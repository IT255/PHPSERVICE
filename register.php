<?php




header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: X-XSRF-TOKEN");
include("connection.php");

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = md5($_POST['password']);


if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['password']))
   {


  $stmt = $conn->prepare("INSERT INTO users( firstname, lastname, username, password )  VALUES(?, ?, ?, ?)");
    try{
      $stmt->execute(array( $firstname, $lastname, $username, $password));
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }

  echo "ok";

   }


 ?>
