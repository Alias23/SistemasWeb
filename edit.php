<?php 

  require "database.php";

  session_start();

  if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    return;
  }
  $error = null;
  $user_id = $_SESSION['usuario']['id'];

  // Obtener los datos actuales del usuario
  $sql_user = "SELECT * FROM usuarios WHERE id = $user_id";
  $result_user = $conn->query($sql_user);
  
  if ($result_user->rowCount() > 0) {
      $user_data = $result_user->fetch(PDO::FETCH_ASSOC);
  } else {
      echo "Usuario no encontrado";
      exit;
  }
  
  // Verificar si se ha enviado el formulario de edición
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Obtener los nuevos datos del formulario
      $new_name = $_POST['name'];
      $new_apellidos = $_POST['apellidos'];
      $new_phone_number = $_POST['phone_number'];
      $new_email = $_POST['email'];
      $new_password = $_POST['password'];
      $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
      
  
      // Actualizar los datos del usuario
      $sql_update_user = "UPDATE usuarios SET name='$new_name', apellidos='$new_apellidos', phone_number='$new_phone_number', email='$new_email', password='$hashedPassword' WHERE id=$user_id";
  
      $conn->query($sql_update_user);
      
      // También actualiza los datos en la tabla de contactos
      $sql_update_contactos = $conn->prepare("UPDATE contactos SET name='$new_name', apellidos='$new_apellidos', phone_number='$new_phone_number', email='$new_email' WHERE id_usuario=$user_id");
      $sql_update_contactos->execute();
      header("Location: edit.php");
      return;
  }
?>

<?php require "partials/header.php"; ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit User</div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <p class="text-danger"><?= $error ?></p>
                    <?php endif ?>
                    <form id="form" method="POST" action="" onsubmit="return formValidation()">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="<?php echo $user_data['name']; ?>" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="apellidos" class="col-md-4 col-form-label text-md-end">Apellidos</label>
                            <div class="col-md-6">
                                <input id="apellidos" type="text" class="form-control" name="apellidos" value="<?php echo $user_data['apellidos']; ?>" required autocomplete="apellidos" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="DNI" class="col-md-4 col-form-label text-md-end">DNI</label>
                            <div class="col-md-6">
                                <input id="DNI" type="text" class="form-control" name="DNI" value="<?php echo $user_data['DNI']; ?>" required autocomplete="DNI" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
                            <div class="col-md-6">
                                <input id="phone_number" type="tel" class="form-control" name="phone_number" value="<?php echo $user_data['phone_number']; ?>" required autocomplete="phone_number" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="fecha_de_nacimiento" class="col-md-4 col-form-label text-md-end">Fecha de nacimiento</label>
                            <div class="col-md-6">
                                <input id="fecha_de_nacimiento" type="date" class="form-control" name="fecha_de_nacimiento" value="<?php echo $user_data['fecha_de_nacimiento']; ?>" required autocomplete="fecha_de_nacimiento" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo $user_data['email']; ?>" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-end">Password</label>
                            <div class="col-md-6">
                            <input id="password" type="text" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "partials/footer.php"; ?>


