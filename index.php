<?php

require "database.php";

$contactos = $conn-> query("SELECT * FROM contactos");

?>

<?php require "partials/header.php"?>
<div class="container pt-4 p-3">
  <div class="row">
    <?php if ($contactos->rowCount() == 0): ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="add.php">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <?php foreach($contactos as $contacto): ?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contacto["name"] ?></h3>
            <p class="m-2"><?= $contacto["phone_number"] ?></p>
            <a href="edit.php?id=<?= $contacto["id"]?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <a href="delete.php?id=<?= $contacto["id"]?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php require "partials/footer.php"?>
