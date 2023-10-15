<?php
session_start();
if (isset($_SESSION["usuario"])) {
  header("Location: home.php");
  return;
}
?>
<?php require "partials/header.php";?>
<div class="welcome d-flex align-items-center justify-content-center">
  <div class="text-center">
    <h1>Almacena tus contactos</h1>
    <a class="btn btn-lg btn-dark" href="/register.php">Registrate ahora</a>
  </div>
</div>

<?php require "partials/footer.php"?>
