<?php 

require "database.php";
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
    // Si han pasado más de 10 minutos, destruye la sesión
    session_unset();     // Elimina todas las variables de sesión
    session_destroy();   // Destruye la sesión
  }
  
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    return;
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $error = "Por favor, rellena todos los campos.";
    } else {
        $email = $_POST["email"];
        $statement = $conn->prepare("SELECT * FROM usuarios WHERE email = '$email' LIMIT 1 ");
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $error = "No existe ningún usuario con este email";
        } else {
            $usuario = $statement->fetch(PDO::FETCH_ASSOC);
            $email = $_POST["email"];
            if ($email != $_SESSION["usuario"]["email"]){
              $id = $usuario["id"];
              $statementcom = $conn->prepare("SELECT * FROM contactos WHERE id_usuario = '$id' && id = {$_SESSION['usuario']['id']}");
              $statementcom->execute();
              if ($statementcom->rowCount() == 0){
                $nombre = $usuario["name"];
                $apellidos = $usuario["apellidos"];
                $phone = $usuario["phone_number"];
                $statement2 = $conn->prepare("INSERT INTO contactos (id, email, name, apellidos, phone_number, id_usuario) VALUES ({$_SESSION['usuario']['id']},:email, :nombre, :apellidos, :phone, :id_usuario)");
                $statement2->bindParam(':email', $email, PDO::PARAM_STR);
                $statement2->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $statement2->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
                $statement2->bindParam(':phone', $phone, PDO::PARAM_STR);
                $statement2->bindParam(':id_usuario', $id, PDO::PARAM_STR);
                $statement2->execute();

                $_SESSION["flash"] = ["message" => "Contacto {$nombre} added."];
                header("Location: home.php");
                return;
              }else{
                $error = "Ese contacto ya está añadido";
            }}else {
              $error = "Ese es tu correo";
            }
        }
    }
}
?>
<?php
// Aquí deberías incluir la conexión a tu base de datos

// Consulta para obtener la lista de usuarios
$sql = $conn->prepare("SELECT email FROM usuarios");
$sql->execute();

if ($sql->rowCount() > 0) {
    // Construir la lista de usuarios
    $userList = "<ul>";
    while($row = $sql->fetch()) {
        $userList .= "<li>" . $row["email"] . "</li>";
    }
    $userList .= "</ul>";

    // Mostrar la lista solo cuando se realiza una solicitud AJAX
    if (isset($_POST['ajax'])) {
        echo $userList;
        exit;
    }
} else {
    echo "No hay usuarios";
}

// Cierra la conexión a la base de datos
//$mysqli->close();
?>

<?php require "partials/header.php" ?>
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
                            <label for="name" class="col-md-4 col-form-label text-md-end">Email</label>
                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" required autocomplete="name" autofocus>
                                
                                <!-- Nuevo div para mostrar la lista de usuarios -->
                                <div id="user-list-container" class="user-list-container"></div>
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

<!-- Agregamos el script de jQuery directamente aquí -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function(){
    // Cuando se hace clic en la caja de texto
    $("#email").click(function(){
        // Realiza una llamada AJAX para obtener la lista de usuarios
        $.ajax({
            type: 'POST',
            url: window.location.href, // Envía la solicitud al mismo archivo
            data: {ajax: true}, // Envía una bandera para identificar la solicitud AJAX
            success: function(data){
                // Coloca la lista de usuarios en el contenedor
                $("#user-list-container").html(data);
                
                // Muestra el contenedor
                $("#user-list-container").slideDown();
            }
        });
    });

    // Cuando se hace clic fuera del contenedor, ocúltalo
    $(document).click(function(event) {
        if (!$(event.target).closest('#user-list-container, #email').length) {
            $("#user-list-container").slideUp();
        }
    });
});
</script>
<style>
.user-list-container {
    display: none;
    max-height: 150px;
    overflow-y: auto;
    border: 1px solid #ccc;
    position: absolute;
    width: 100%;
    white-space: nowrap; /* Evita que los usuarios se dividan en múltiples líneas */
}

.user-list-container ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.user-list-container li {
    padding: 5px;
    border-bottom: 1px solid #ddd;
}
</style>

<?php require "partials/footer.php" ?>
