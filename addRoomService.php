<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Token, token, TOKEN');
include("functions.php");

// if(isset($_POST['broj_kvadrata']) &&
//    isset($_POST['broj_kreveta'])  &&
//    isset($_POST['sprat']) &&
//    isset($_POST['cena']) &&
//    isset($_POST['tip_sobe']))
//
// {
//   $brojKvadrata = $_POST['broj_kvadrata'];
//   $brojKreveta = $_POST['broj_kreveta'];
//   $sprat = $_POST['sprat'];
//   $cena = $_POST['cena'];
//   $tipSobe = $_POST['tip_sobe'];
// echo addRoom($brojKvadrata, $brojKreveta, $sprat, $cena, $tipSobe);
// }



if(isset($_POST['roomname']) &&
   isset($_POST['broj_kvadrata']) &&
   isset($_POST['broj_kreveta'])  &&
   isset($_POST['sprat']) &&
   isset($_POST['cena']) &&
   isset($_POST['room_type_id']))
   {

    echo $roomname = $_POST['roomname'];
    echo $brojKvadrata = $_POST['broj_kvadrata'];
    echo $brojKreveta = $_POST['broj_kreveta'];
    echo $sprat = $_POST['sprat'];
    echo $cena = $_POST['cena'];
    echo $room_type_id = $_POST['room_type_id'];


    if(isset($_POST['room_type_id']) && !empty($_POST['room_type_id'])){
      $room_type_id = intval($_POST['room_type_id']);
    } else{
      $room_type_id = null;
    }
  echo addRoom($roomname, $brojKvadrata, $brojKreveta, $sprat, $cena, $room_type_id);
}

 ?>
