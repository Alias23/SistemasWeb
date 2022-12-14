<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand font-weight-bold" href="index.php">
      <img class="mr-2" src="./static/img/logo.png" />
      AgendaContactos
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <div class="d-flex justify-content-between w-100">
        <li class="nav-item">
          <a class="nav-link" href="home.php"">Home</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="./add.php">Add Contact</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" href="register.php"">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        </div>
      </ul>
      <?php if (isset($_SESSION["usuario"])): ?>
        <div class="p-2">
          <?= $_SESSION["usuario"]["email"] ?>
        </div>
      <?php endif ?>
    </div>
  </div>
</nav>
