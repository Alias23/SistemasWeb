<?php 

$host = "localhost";
$database = "agendacontactos";
$user = "root";
$password = "";

try{
  $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
  // prueba para ver si funciona correctamente:
  // foreach($conn -> query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
  // die();
}catch(PDOexception $e){
  die("PDO connection error: " . $e-> getMessage());
}

