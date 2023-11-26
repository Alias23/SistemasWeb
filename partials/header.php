<?php
// partials/header.php

// Función para generar y almacenar el token CSRF
function generarYAlmacenarTokenCSRF() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

// Si no hay un token CSRF almacenado, generarlo y almacenarlo
if (!isset($_SESSION['csrf_token'])) {
    generarYAlmacenarTokenCSRF();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">


  <!-- Bootstrap -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.1.3/darkly/bootstrap.min.css"
    integrity="sha512-ZdxIsDOtKj2Xmr/av3D/uo1g15yxNFjkhrcfLooZV5fW0TT7aF7Z3wY1LOA16h0VgFLwteg14lWqlYUQK3to/w=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
  <script
    defer
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
  ></script>

  <!-- Static Content -->
  <link rel="stylesheet" href="./static/css/index.css" />
  <script defer src="./static/js/validar.js"></script>

  <link rel="stylesheet" href="./static/css/index.css" />
  <script defer src="./static/js/validarEdit.js"></script>

  <script>
    function imprimirCampoCSRF() {
        document.write('<input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">');
    }
  </script>
  <title>AgendaContactos</title>
</head>
<body>
<?php require "navbar.php"?>  
<main>


