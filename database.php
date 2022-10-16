<?php 

$host = "localhost";
$database = "agendacontactos";
$usuario = "root";
$password = "";

try{
  $conn = new PDO("mysql:host=$host;dbname=$database", $usuario, $password);
  // prueba para ver si funciona correctamente:
  // foreach($conn -> query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
  // die();
}catch(PDOexception $e){
  die("PDO connection error: " . $e-> getMessage());
}

