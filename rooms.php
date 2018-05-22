<?php
// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: GET, POST');
// header("Access-Control-Allow-Headers: X-XSRF-TOKEN");
// function get_data(){
//   include("connection.php");
//   header("Access-Control-Allow-Origin: *");
//   header('Access-Control-Allow-Methods: GET, POST');
//   header("Access-Control-Allow-Headers: X-XSRF-TOKEN");
//   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//   $num_rows = $conn->query("SELECT * FROM rooms");
//   //looping trough query
//   while ($row = $num_rows->fetch()){
//
//          $array[] = array(
//              "cena" => $row['cena'],
//              'broj_kvadrata'=>$row['broj_kvadrata'],
//              'broj_kreveta'=>$row['broj_kreveta']
//            );
//   }
//
//
// return json_encode($array);
//
//
// }




// $filename = 'rooms.json';
//
// if(file_put_contents($filename, get_data())){
//   echo 'file created';
// }else {
//   echo 'error';
// }





include("connection.php");
header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Methods: GET, POST');
// header("Access-Control-Allow-Headers: X-XSRF-TOKEN");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$num_rows = $conn->query("SELECT * FROM rooms");
//looping trough query
while ($row = $num_rows->fetch()){

       $array[] = array(
           "cena" => $row['cena'],
           'broj_kvadrata'=>$row['broj_kvadrata'],
           'broj_kreveta'=>$row['broj_kreveta'],
           'roomname' =>$row['roomname'],
           'sprat'=>$row['sprat'],
           'room_type_id'=>$row['room_type_id']
         );
}

    header('Content-Type: application/json');
    echo json_encode( $array );





 ?>
