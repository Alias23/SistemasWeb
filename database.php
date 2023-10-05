<?php 

$host = "127.0.0.1";
$database = "agendacontactos";
$usuario = "root";
$password = "root";

try{
  $conn = new PDO("mysql:host=$host;port=8889;dbname=$database", $usuario, $password);
  // prueba para ver si funciona correctamente:
  // foreach($conn -> query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
  // die();
}catch(PDOexception $e){
  die("PDO connection error: " . $e-> getMessage());
}

