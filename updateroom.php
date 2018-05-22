<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token ,Authorization, Token, token, TOKEN');

include("functions.php");

if(isset($_POST['roomname']) &&
   isset($_POST['broj_kvadrata']) &&
   isset($_POST['broj_kreveta'])  &&
   isset($_POST['sprat']) &&
   isset($_POST['cena']) &&
   isset($_POST['id'])){



   echo $roomname = $_POST['roomname'];
   echo $brojKvadrata = $_POST['broj_kvadrata'];
   echo $brojKreveta = $_POST['broj_kreveta'];
   echo $sprat = $_POST['sprat'];
   echo $cena = $_POST['cena'];
   echo $id = intval($_POST['id']);

echo updateRoom($roomname, $brojKvadrata, $brojKreveta, $sprat, $cena, $id);
}


 ?>
