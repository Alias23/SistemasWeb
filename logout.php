<?php
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
  // Si han pasado más de 10 minutos, destruye la sesión
  session_unset();     // Elimina todas las variables de sesión
  session_destroy();   // Destruye la sesión
}

session_start();
session_destroy();
header("Location: index.php");
return;
