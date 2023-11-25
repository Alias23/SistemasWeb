<?php

require "database.php";
session_set_cookie_params(0, '/', '', false, true);
session_start();
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
  // Si han pasado más de 10 minutos, destruye la sesión
  session_unset();     // Elimina todas las variables de sesión
  session_destroy();   // Destruye la sesión
}

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
