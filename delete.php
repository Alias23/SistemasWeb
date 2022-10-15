<?php

require "database.php";

$id = $_GET["id"];

$statement = $conn->prepare("DELETE FROM contactos WHERE id = '$id'");
$statement->execute();

header("Location : index.php");
