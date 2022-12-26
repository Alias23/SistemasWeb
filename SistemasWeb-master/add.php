<?php 

  require "database.php";

  session_start();

  if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    return;
  }

  $error=null;
  

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["name"]) || empty($_POST["phone_number"])) {
      $error = "Por favor rellena todos los campos.";
    } else if (strlen($_POST["phone_number"]) < 9) {
      $error = "El numero de telefono debe tener 9 caracteres.";
    } else {
      $name = $_POST["name"];
      $apellidos = $_POST["apellidos"];
      $empresa = $_POST["empresa"];
      $phoneNumber = $_POST["phone_number"];
      $secondPhoneNumber = $_POST["second_phone_number"];
      $statement = $conn->prepare("INSERT INTO contactos (id_usuario, name, apellidos, empresa, phone_number, second_phone_number) VALUES ({$_SESSION['usuario']['id']},'$name', '$apellidos', '$empresa', '$phoneNumber', '$secondPhoneNumber')");
      $statement->execute();

      $_SESSION["flash"] = ["message" => "Contacto {$_POST['name']} added."];
  
      header("Location: home.php");
      return;
    }
  }
?>

<?php require "partials/header.php"?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
          <div class="card-body">
            <?php if ($error): ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif ?>
            <form method="POST" action="add.php">

              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="apellidos" class="col-md-4 col-form-label text-md-end">Apellidos</label>
                <div class="col-md-6">
                  <input id="apellidos" type="text" class="form-control" name="apellidos" required autocomplete="apellidos" autofocus>
                </div>
              </div>
              
              <div class="mb-3 row">
                <label for="empresa" class="col-md-4 col-form-label text-md-end">Empresa</label>
                <div class="col-md-6">
                  <input id="empresa" type="text" class="form-control" name="empresa" required autocomplete="empresa" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                <div class="col-md-6">
                  <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="second_phone_number" class="col-md-4 col-form-label text-md-end">Second Phone Number</label>
                <div class="col-md-6">
                  <input id="second_phone_number" type="tel" class="form-control" name="second_phone_number" required autocomplete="second_phone_number" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require "partials/footer.php"?>
