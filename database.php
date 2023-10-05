<?php 

$host = "db";
$database = "agendacontactos";
$puerto = "3306";
$usuario = "root";
$password = "root";

try{
  $conn = new PDO("mysql:host=$host;port=$puerto;dbname=$database", $usuario, $password);
  // prueba para ver si funciona correctamente:
  // foreach($conn -> query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
  // die();
}catch(PDOexception $e){
  die("PDO connection error: " . $e-> getMessage());
}

