<?php 

require "database.php";

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

<?php require "partials/footer.php" ?>
