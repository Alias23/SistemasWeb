<?php 

  require "database.php";

  $id = $_GET["id"];

  $statement = $conn->prepare("SELECT * FROM contactos WHERE id = '$id' LIMIT 1");
  $statement->execute();

  $contacto = $statement->fetch(PDO::FETCH_ASSOC);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $phoneNumber = $_POST["phone_number"];
    $statement = $conn->prepare("UPDATE contactos SET name = '$name', phone_number = '$phoneNumber' WHERE id = '$id '");
    $statement->execute();
    
    header("Location: index.php");
  }
?>

<?php require "partials/header.php"?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <form method="POST" action="edit.php?id=<?= $contacto["id"] ?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input value="<?= $contacto["name"]?>" id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input value="<?= $contacto["phone_number"]?>" id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
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

