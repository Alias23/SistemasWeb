<?php
require "database.php";
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
    // Si han pasado más de 10 minutos, destruye la sesión
    session_unset();     // Elimina todas las variables de sesión
    session_destroy();   // Destruye la sesión
  }
  session_set_cookie_params(0, '/', '', true, true);  
  session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    return;
}

function getMensajes($conn, $id_emisor, $id_receptor) {
    $query = "SELECT * FROM mensajes WHERE (id_emisor = :id_emisor AND id_receptor = :id_receptor) OR (id_emisor = :id_receptor AND id_receptor = :id_emisor) ORDER BY fecha_envio";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id_emisor', $id_emisor, PDO::PARAM_INT);
    $statement->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_receptor = intval($_POST["id_receptor"]);
    $mensaje = $_POST["mensaje"];
    $id_emisor = intval($_SESSION["usuario"]["id"]);

    $verificarUsuario = $conn->prepare("SELECT id FROM usuarios WHERE id = :id_receptor");
    $verificarUsuario->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
    $verificarUsuario->execute();

    if ($verificarUsuario->rowCount() == 0) {
        $error = "Ha habido un error";
        header("Location: chat.php?id_receptor=" . $id_receptor);
        return;
    } else {
        try {
            $statementcom = $conn->prepare("SELECT * FROM contactos WHERE id = '$id_receptor' && id_usuario = {$_SESSION['usuario']['id']}");
            $statementcom->execute();
            if ($statementcom->rowCount() == 0){
              $statement2 = $conn->prepare("SELECT * FROM usuarios WHERE id = '$id_emisor'");
              $statement2->execute();
              $usuario = $statement2->fetch(PDO::FETCH_ASSOC);
              $email = $usuario["email"];
              $nombre = $usuario["name"];
              $apellidos = $usuario["apellidos"];
              $phone = $usuario["phone_number"];
              $statement2 = $conn->prepare("INSERT INTO contactos (id, email, name, apellidos, phone_number, id_usuario) VALUES ($id_receptor,:email, :nombre, :apellidos, :phone, {$_SESSION['usuario']['id']})");
              $statement2->bindParam(':email', $email, PDO::PARAM_STR);
              $statement2->bindParam(':nombre', $nombre, PDO::PARAM_STR);
              $statement2->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
              $statement2->bindParam(':phone', $phone, PDO::PARAM_STR);
              $statement2->execute();
            }
            $statement = $conn->prepare("INSERT INTO mensajes (id_emisor, id_receptor, mensaje) VALUES (:id_emisor, :id_receptor, :mensaje)");
            $statement->bindParam(':id_emisor', $id_emisor, PDO::PARAM_INT);
            $statement->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
            $statement->bindParam(':mensaje', $mensaje, PDO::PARAM_STR);
            $statement->execute();
            header("Location: chat.php?id_receptor=" . $id_receptor . "&id_emisor=" . $id_emisor);
            return;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(),"\n";
        }
    }
}

$id_receptor = intval($_GET["id_receptor"]);
$id_emisor = intval($_GET["id_emisor"]);
$mensajes = getMensajes($conn, $id_emisor, $id_receptor);
?>

<?php require "partials/header.php" ?>
<div class="container pt-4 p-3">
  <?php $statement2 = $conn->prepare("SELECT * FROM usuarios WHERE id = '$id_receptor'");
              $statement2->execute();
              $usuario = $statement2->fetch(PDO::FETCH_ASSOC);
              $nombre = $usuario["name"];
  ?>
    <p>Estás hablando con: <?= $nombre ?></p>

    <!-- Mostrar mensajes en una caja con barra de desplazamiento -->
    <div style="max-height: 500px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
        <h3 class="message-heading">Mensajes</h3>
        <ul>
            <?php foreach ($mensajes as $mensaje) : ?>
              <li style="font-size: 16px;">
                <?= $mensaje["mensaje"] ?> - <span style="font-weight: bold; color: red;"><?= $mensaje["id_emisor"] == $id_emisor ? "Yo" : $nombre ?></span>
              </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Formulario para enviar mensajes -->
    <form method="POST" action="chat.php">
        <input type="hidden" name="id_receptor" value="<?= $_GET["id_receptor"] ?>">
        <input type="hidden" name="id_emisor" value="<?= $_GET["id_emisor"] ?>">
        <textarea name="mensaje" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
        <button type="submit">Enviar mensaje</button>
    </form>
</div>
<?php require "partials/footer.php" ?>
