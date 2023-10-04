<?php 

require "database.php";

$error = null;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty($_POST["name"]) || empty($_POST["apellidos"]) || empty($_POST["DNI"]) || empty($_POST["phone_number"]) || empty($_POST["fecha_de_nacimiento"]) || empty($_POST["email"]) || empty($_POST["password"])){
    $error = "Por favor rellena todos los campos.";
    // var_dump($_POST);
    // die();
  } else if(!str_contains($_POST["email"], "@")){
    $error = "Email invalido." ;
  } else {
    $name = $_POST["name"];
    $apellidos = $_POST["apellidos"];
    $DNI = $_POST["DNI"];
    $phoneNumber = $_POST["phone_number"];
    $fechaDeNacimiento = $_POST["fecha_de_nacimiento"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $statement = $conn->prepare("SELECT * FROM usuarios WHERE email = '$email' ");
    $statement->execute();

    if ($statement->rowCount() > 0){
      $error="Email repetido";
    } else {
      $conn->prepare("INSERT INTO usuarios (name,apellidos,DNI,phone_number,fecha_de_nacimiento,email,password) VALUES ('$name','$apellidos', '$DNI', '$phoneNumber', '$fechaDeNacimiento', '$email', '$password')")->execute();
    }

    $statement = $conn->prepare("SELECT * FROM usuarios WHERE email = '$email' LIMIT 1");
    $statement->execute();
    $usuario = $statement->fetch(PDO::FETCH_ASSOC);

    session_start();
    $_SESSION["usuario"] = $usuario;

    header("Location: home.php");
  }
  }
?>

<?php require "partials/header.php"?>
<div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Registrarse</div>
          <div class="card-body">
            <?php if ($error): ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif?>
            <form id="form" method="POST" action="register.php" onsubmit="return formValidation()">
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
                <label for="DNI" class="col-md-4 col-form-label text-md-end">DNI</label>

                <div class="col-md-6">
                  <input id="DNI" type="id" class="form-control" name="DNI" required autocomplete="DNI" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

                <div class="col-md-6">
                  <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="fecha_de_nacimiento" class="col-md-4 col-form-label text-md-end">Fecha de nacimineto</label>

                <div class="col-md-6">
                  <input id="fecha_de_nacimiento" type="date" class="form-control" name="fecha_de_nacimiento" required autocomplete="fecha_de_nacimiento" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                </div>
              </div>
              <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end">Contraseña</label>

                <div class="col-md-6">
                  <input id="password" type="text" class="form-control" name="password" required autocomplete="password" autofocus>
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
<?php require "partials/footer.php"?>

