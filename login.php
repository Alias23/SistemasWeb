<?php
require "database.php";

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $error = "Por favor rellena todos los campos.";
    } else if (strpos($_POST["email"], "@")==false) {
        $error = "Email invalido.";
    } else {
        session_start();
        session_destroy();

        $email = $_POST["email"];
        $password = $_POST["password"];
        $statement = $conn->prepare("SELECT * FROM usuarios WHERE email = '$email' LIMIT 1 ");
        $statement->execute();

        if ($statement->rowCount() == 0) {
            $error = "Las credenciales no coindiden o no existe usuario.";
        } else {
            $usuario = $statement->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($password, $usuario["password"])) {
                $error = "Las credenciales no coinciden.";
            } else {
                session_start();
                $_SESSION["usuario"] = $usuario;
                header("Location: home.php");
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
                <div class="card-header">Login</div>
                <div class="card-body">
                    <?php if ($error) : ?>
                        <p class="text-danger">
                            <?= $error ?>
                        </p>
                    <?php endif ?>
                    <form method="POST" action="login.php">

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
<?php require "partials/footer.php" ?>
