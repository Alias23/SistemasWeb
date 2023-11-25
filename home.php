<?php

require "database.php";
session_set_cookie_params(0, '/', '', false, true);
session_start();
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
  // Si han pasado más de 10 minutos, destruye la sesión
  session_unset();     // Elimina todas las variables de sesión
  session_destroy();   // Destruye la sesión
}

// Actualiza el tiempo de última actividad
$_SESSION['last_activity'] = time();

if (!isset($_SESSION["usuario"])) {
  header("Location: login.php");
  return;
}

$contactos = $conn-> query("SELECT * FROM contactos WHERE id = {$_SESSION['usuario']['id']}");

?>

<?php require "partials/header.php"?>
<div class="container pt-4 p-3">
  <div class="row">
    <?php if ($contactos->rowCount() == 0): ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No se ha guardado ningún contacto</p>
          <a href="add.php">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <?php foreach($contactos as $contacto): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contacto["name"] ?></h3>
            <p class="m-2"><?= $contacto["apellidos"] ?></p>
            <p class="m-2"><?= $contacto["email"] ?></p>
            <p class="m-2"><?= $contacto["phone_number"] ?></p>
            <a href="delete.php?id=<?= $contacto["id"]?>" class="btn btn-danger mb-2">Delete Contact</a>
            <div class="card card-body text-center">
            <a href="chat.php?id_receptor=<?= $contacto["id_usuario"]?>&id_emisor=<?=$_SESSION['usuario']['id']?>" class="btn btn-primary mb-2">Abrir chat</a>
          </div>
      </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
    <?php if ($contactos->rowCount() > 0): ?>
      <div class="card card-body text-center">
            <p>Añade más contactos</p>
            <a href="add.php">Add One!</a>
          </div>
      </div>
  <?php endif ?>
</div>
<?php require "partials/footer.php"?>
