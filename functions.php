<?php


// $stmt = $conn->prepare(" SELECT * FROM users WHERE username = ?");
//         try{
//             $stmt -> execute(array($username));
//             //$sql = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             if($stmt->fetchColumn() > 0){
//
//                 return true;
//             }else{
//
//                 return false;
//             }
//         } catch (PDOException $ex) {
//                 echo $ex->getMessage();
//         }

  include "connection.php";

  if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    die();
  }
function checkIfLoggedIn(){
  global $conn;
  if(isset($_SERVER['HTTP_TOKEN'])){
    $token = $_SERVER['HTTP_TOKEN'];
    $result = $conn->prepare("SELECT * FROM users WHERE token=?");
    try{
      $result-> execute(array($token));
      if($result->fetchColumn() > 0){
          return true;
      }else{
          return false;
      }
    } catch (PDOException $ex) {
            echo $ex->getMessage();
    }
  }
  else{
    return false;
  }
}


function login($username, $password){
  global $conn;
  $rarray = array();
  if(checkLogin($username,$password)){
  $id = sha1(uniqid());
  $result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
  $result2-> execute(array($id, $username));
  $rarray['token'] = $id;
  } else{
    header('HTTP/1.1 401 Unauthorized');
    $rarray['error'] = "Invalid username/password";
  }
    return json_encode($rarray);
}



function checkLogin($username, $password){
  global $conn;
  $password = md5($password);
  $result = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
  $result-> execute(array($username, $password));
  if($result->fetchColumn() > 0)
  {
  return true;
  }
  else{
  return false;
  }
}



//
// function checkUsers($username, $pass){
//       global $conn;
//       $stmt = $conn->prepare(" SELECT * FROM users WHERE username = ? AND password = ?");
//         try{
//             $stmt -> execute(array($username, md5($pass)));
//             //$sql = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             if($stmt->fetchColumn() > 0){
//                 return true;
//             }else{
//               return false;
//                 echo 'No';
//             }
//         } catch (PDOException $ex) {
//                 echo $ex->getMessage();
//         }
// }


function register($username, $password, $firstname, $lastname){
    global $conn;
    $rarray = array();
    $errors = "";
  if(checkIfUserExists($username)){
    $errors .= "Username already exists\r\n";
  }
  if(strlen($username) < 5){
    $errors .= "Username must have at least 5 characters\r\n";
  }
  if(strlen($password) < 5){
    $errors .= "Password must have at least 5 characters\r\n";
  }
  if(strlen($firstname) < 3){
    $errors .= "First name must have at least 3 characters\r\n";
  }
  if(strlen($lastname) < 3){
    $errors .= "Last name must have at least 3 characters\r\n";
  }
  if($errors == ""){
      $stmt = $conn->prepare("INSERT INTO users( firstname, lastname, username, password )  VALUES(?, ?, ?, ?)");
        try{
          $pass =md5($password);
          $stmt->execute(array( $firstname, $lastname, $username, $pass));
          if($stmt->execute()){
            $id = sha1(uniqid());
          //  $result2->prepare($sql)->execute([$name, $id]);
            $result2 = $conn->prepare("UPDATE users SET token=? WHERE username=?");
            $result2->execute([$id, $username]);
            $rarray['token'] = $id;
          }
        }
        catch(PDOException $e) {
          echo $e->getMessage();
        }
    }else{
      header('HTTP/1.1 400 Bad request');
      $rarray['error'] = "Database connection error";
    }
    return json_encode($rarray);
}


function checkIfUserExists($username){
  global $conn;
  $result = $conn->prepare("SELECT * FROM users WHERE username=?");
  $result-> execute(array($username));
  if($result->fetchColumn() > 0)
  {
  return true;
  }
  else{
  return false;
  }
}


//rooms($roomName, $hasTV, $beds, $room_type_id

function addRoom($roomName,$brojKvadrata, $brojKreveta, $sprat, $cena, $room_type_id){
  global $conn;
  $rarray = array();
  echo $room_type_id;
  if(checkIfLoggedIn()){
  $stmt = $conn->prepare("INSERT INTO rooms(roomname, broj_kvadrata, broj_kreveta, sprat,cena,room_type_id )  VALUES(?, ?, ?, ?, ?, ?)");
    try{
      $stmt->execute(array( $roomName,$brojKvadrata, $brojKreveta, $sprat, $cena, $room_type_id));
    }
    catch(PDOException $e) {
      echo $e->getMessage();
    }

  // if($stmt->execute()){
  // $rarray['success'] = "ok";
  // }else{
  // $rarray['error'] = "Database connection error";
  // }
  } else{
  $rarray['error'] = "Please log in";
  header('HTTP/1.1 401 Unauthorized');
  }
  return json_encode($rarray);
}


function getRooms(){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){
    $result = $conn->query("SELECT id, roomname, broj_kvadrata, broj_kreveta, sprat, cena, room_type_id, (SELECT name FROM room_type WHERE id=rooms.room_type_id) as room_type FROM rooms");
    $rooms = array();
    if($result->fetchColumn() > 0)
    {
    $result2 = $conn->query("SELECT rooms.id, roomname, broj_kvadrata, broj_kreveta, sprat, cena, room_type_id, (SELECT name FROM room_type WHERE id=rooms.room_type_id) as room_type FROM rooms");
    while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
    $one_room = array();
    $one_room['id'] = $row['id'];
    $one_room['roomname'] = $row['roomname'];
    $one_room['broj_kvadrata'] = $row['broj_kvadrata'];
    $one_room['broj_kreveta'] = $row['broj_kreveta'];
    $one_room['sprat'] = $row['sprat'];
    $one_room['cena'] = $row['cena'];
    $one_room['room_type_id'] = $row['room_type_id'];
    array_push($rooms,$one_room);
    }
    }
    $rarray['rooms'] = $rooms;
    return json_encode($rarray);
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
    return json_encode($rarray);
  }
}



function getRoom($id){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){
  $result = $conn->query("SELECT * FROM rooms WHERE id=".$id);
  $rooms = array();
    if($result->fetchColumn() > 0)
    {
      $result2 = $conn->query("SELECT * FROM rooms");
      while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
      $one_room = array();
      $one_room['id'] = $row['id'];
      $one_room['roomname'] = $row['roomname'];
      $one_room['broj_kvadrata'] = $row['broj_kvadrata'];
      $one_room['broj_kreveta'] = $row['broj_kreveta'];
      $one_room['sprat'] = $row['sprat'];
      $one_room['cena'] = $row['cena'];
      $rooms = $one_room;
    }
}
  $rarray['data'] = $rooms;
  return json_encode($rarray);
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
    return json_encode($rarray);
  }
}




function deleteRoom($id){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){
    $result = $conn->prepare("DELETE FROM rooms WHERE id=?");
    $result->execute(array( $id));
    $rarray['success'] = "Deleted successfully";
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
  }
  return json_encode($rarray);
}


function addRoomType($name){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){
    $stmt = $conn->prepare("INSERT INTO room_type (name) VALUES (?)");
    $stmt->execute(array( $name));

  // if($stmt->execute() == true){
  //   $rarray['success'] = "ok";
  // }else{
  //   $rarray['error'] = "Database connection error";
  // }
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
  }
  return json_encode($rarray);
}



function getRoomTypes(){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){
    $result = $conn->query("SELECT * FROM room_type");
    $room_types = array();
  if($result->fetchColumn() > 0)
  {
    //$row = $sth->fetch(PDO::FETCH_ASSOC)
    $result2 = $conn->query("SELECT * FROM room_type");
    while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
    $one_room = array();
    $one_room['id'] = $row['id'];
    $one_room['name'] = $row['name'];
    array_push($room_types,$one_room);
  }
  }
    $rarray['room_types'] = $room_types;
    return json_encode($rarray);
    } else{
      $rarray['error'] = "Please log in";
      header('HTTP/1.1 401 Unauthorized');
      return json_encode($rarray);
  }
}


function deleteRoomType($id){
    global $conn;
    $rarray = array();
  if(checkIfLoggedIn()){
    $result = $conn->prepare("DELETE FROM room_type WHERE id=?");
    $result->execute(array($id));
    $rarray['success'] = "Deleted successfully";
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
  }
    return json_encode($rarray);
}


function updateRoom($roomname,$brojKvadrata, $brojKreveta, $sprat, $cena, $id){
  global $conn;
  $rarray = array();
 //if(checkIfLoggedIn()){



    $sql = "UPDATE rooms SET roomname =?, broj_kvadrata =?, broj_kreveta =?, sprat =?, cena =? WHERE id=?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$roomname,$brojKvadrata, $brojKreveta, $sprat, $cena, $id]);

  if($stmt->execute()){
  $rarray['success'] = "updated";
  }else{
  $rarray['error'] = "Database connection error";
  }
  // } else{
  //   $rarray['error'] = "Please log in";
  //   header('HTTP/1.1 401 Unauthorized');
  // }
  return json_encode($rarray);
}




function getRoomWithId($id){
  global $conn;
  $rarray = array();
  if(checkIfLoggedIn()){

    $result = $conn->query("SELECT * FROM rooms WHERE id=".$id);
    $rooms = array();
    if($result->fetchColumn() > 0)
    {
    $result2 = $conn->query("SELECT * FROM rooms WHERE id=".$id);
    while($row = $result2->fetch(PDO::FETCH_ASSOC)) {
    $rooms = $row;
    }
    }
    $rarray = $rooms;
    return json_encode($rarray);
  } else{
    $rarray['error'] = "Please log in";
    header('HTTP/1.1 401 Unauthorized');
    return json_encode($rarray);
    }
}



 ?>
