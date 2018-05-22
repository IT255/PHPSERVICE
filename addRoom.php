<?php


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: X-XSRF-TOKEN");
include("connection.php");

$brojKvadrata = $_POST['broj_kvadrata'];
$brojKreveta = $_POST['broj_kreveta'];
$sprat = $_POST['sprat'];
$cena = $_POST['cena'];
$tipSobe = $_POST['tip_sobe'];

if(isset($_POST['broj_kvadrata']) &&
   isset($_POST['broj_kreveta'])  &&
   isset($_POST['sprat']) &&
   isset($_POST['cena']) &&
   isset($_POST['tip_sobe']))

{

  $stmt = $conn->prepare("INSERT INTO rooms( broj_kvadrata, broj_kreveta, sprat,cena,tip_sobe )  VALUES(?, ?, ?, ?, ?)");
    try{
      $stmt->execute(array( $brojKvadrata, $brojKreveta, $sprat, $cena, $tipSobe));
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }

  echo "ok";

  // $stmt = $conn->prepare("INSERT INTO rooms (broj_kvadrata, broj_kreveta, sprat,cena,tip_sobe) VALUES (?, ?, ?, ?, ?)");
  // $stmt->bind_param("sssss", $brojKvadrata, $brojKreveta, $sprat, $cena, $tipSobe);
  // $stmt->execute();
  // echo "ok";
}



 ?>
