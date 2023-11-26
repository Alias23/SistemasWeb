<?php

require "database.php";
session_set_cookie_params(0, '/', '', true, true);
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
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $new_fecha = $_POST['fecha_de_nacimiento'];
    $new_dni = $_POST['DNI'];

    // Verificar si la casilla de verificación correspondiente está marcada antes de actualizar
    if (isset($_POST['update_name'])) {
        $user_data['name'] = $new_name;
    }

    if (isset($_POST['update_apellidos'])) {
        $user_data['apellidos'] = $new_apellidos;
    }

    if (isset($_POST['update_phone_number'])) {
        $user_data['phone_number'] = $new_phone_number;
    }
    if (isset($_POST['update_dni'])) {
        $user_data['DNI'] = $new_dni;
    }

    if (isset($_POST['update_email'])) {
        $user_data['email'] = $new_email;
    }
    if (isset($_POST['update_fecha'])) {
        $user_data['fecha_de_nacimiento'] = $new_fecha;
    }
    // Verificar la contraseña antes de actualizar la contraseña
    if (password_verify($current_password, $_SESSION['usuario']["password"])) {
        if(isset($_POST['update_password'])){
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $user_data['password'] = $hashedPassword;
        }
        
        // Actualizar los datos del usuario
        $sql_update_user = $conn->prepare("UPDATE usuarios SET name=:name, apellidos=:apellidos, phone_number=:phone_number, email=:email, DNI=:dni, fecha_de_nacimiento=:fecha_de_nacimiento, password=:password WHERE id=:user_id");
        $sql_update_user->bindParam(':name', $user_data['name'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':apellidos', $user_data['apellidos'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':phone_number', $user_data['phone_number'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':email', $user_data['email'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':password', $user_data['password'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':dni', $user_data['DNI'], PDO::PARAM_STR);
        $sql_update_user->bindValue(':fecha_de_nacimiento', $user_data['fecha_de_nacimiento'], PDO::PARAM_STR);
        $sql_update_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql_update_user->execute();

        // También actualiza los datos en la tabla de contactos
        $sql_update_contactos = $conn->prepare("UPDATE contactos SET name=:name, apellidos=:apellidos, phone_number=:phone_number, email=:email WHERE id_usuario=:user_id");
        $sql_update_contactos->bindParam(':name', $user_data['name'], PDO::PARAM_STR);
        $sql_update_contactos->bindParam(':apellidos', $user_data['apellidos'], PDO::PARAM_STR);
        $sql_update_contactos->bindParam(':phone_number', $user_data['phone_number'], PDO::PARAM_STR);
        $sql_update_contactos->bindParam(':email', $user_data['email'], PDO::PARAM_STR);
        $sql_update_contactos->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql_update_contactos->execute();
        header("Location: edit.php");
        return;
    

    
        
    } else  {
        $error = "La contraseña actual es incorrecta.";
        
    }
    
}

// Definición de la función enviarMensaje


?>

<?php require "partials/header.php"; ?>

<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit User - Introduce tu contraseña para realizar cualquier cambio y marca las casillas que quieres cambiar</div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <p class="text-danger"><?= $error ?></p>
                    <?php endif ?>
                    <form id="form" method="POST" action="edit.php" onsubmit="return formValidationEdit()">
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
                            <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo $user_data['email']; ?>" required autocomplete="email" autofocus>
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
                        
                        <!-- ... (Repite la estructura para otros campos) ... -->

                        <div class="mb-3 row">
                            <label for="password_antigua" class="col-md-4 col-form-label text-md-end">Password</label>
                            <div class="col-md-6">
                                <input id="password_antigua" type="password" class="form-control" name="current_password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="new_password" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <!-- Casillas de verificación para cada campo -->
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_name" id="update_name">
                                    <label class="form-check-label" for="update_name">
                                        Update Name
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_apellidos" id="update_apellidos">
                                    <label class="form-check-label" for="update_apellidos">
                                        Update Apellidos
                                    </label>
                                </div>
                                <!-- Repite para otros campos -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_phone_number" id="update_phone_number">
                                    <label class="form-check-label" for="update_phone_number">
                                        Update Phone Number
                                    </label>
                                </div>
                                <!-- Repite para otros campos -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_email" id="update_email">
                                    <label class="form-check-label" for="update_email">
                                        Update Email
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_dni" id="update_dni">
                                    <label class="form-check-label" for="update_dni">
                                        Update DNI
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_fecha" id="update_fecha">
                                    <label class="form-check-label" for="update_fecha">
                                        Update Fecha Nacimiento
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="update_password" id="update_password">
                                    <label class="form-check-label" for="update_password">
                                        Update Password
                                    </label>
                                </div>
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
