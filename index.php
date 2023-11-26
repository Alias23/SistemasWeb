<?php
session_set_cookie_params(0, '/', '', true, true);
session_start();
if (isset($_SESSION["usuario"])) {
  header("Location: home.php");
  return;
}
?>
<?php require "partials/header.php";?>
<div class="welcome d-flex flex-column align-items-center">
  <div class="text-center">
    <h1>Almacena tus contactos</h1>
    <a class="btn btn-lg btn-dark" href="/register.php">Regístrate ahora</a>
  </div>
  <img class="move-image" src="./static/img/logo2.png" alt="Descripción de la imagen" width="300" height="200">
</div>

<?php require "partials/footer.php"?>
