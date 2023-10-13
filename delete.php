<?php

require "database.php";

session_start();

if (!isset($_SESSION["usuario"])) {
  header("Location: login.php");
  return;
}

$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM contactos WHERE id = '$id' LIMIT 1");
$statement->execute();

$contacto = $statement->fetch(PDO::FETCH_ASSOC);

$statement = $conn->prepare("DELETE FROM contactos WHERE id = '$id'");
$statement->execute();

$_SESSION["flash"] = ["message" => "Contacto {$contacto['name']} deleted."];

header("Location: home.php");
return;
