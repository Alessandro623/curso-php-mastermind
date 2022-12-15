<?php
    require "database.php";
    $error = Null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])) {
            $error = "Please complete all fields";
        } elseif(!str_contains($_POST["email"], "@")) {
            $error = 'Email Invalid';
        } else {
            $statemente = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $statemente->bindParam(":email", $_POST["email"]);
            $statemente->execute();
            if ($statemente->rowCount() > 0){
                $error = "This email is taken";
            } else {
                $conn
                  ->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)")
                  ->execute([
                    ":name" => $_POST["name"],
                    ":email" => $_POST["email"],
                    ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
                  ]);

                  $statemente = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                  $statemente->bindParam(":email", $_POST["email"]);
                  $statemente->execute();
                  $user = $statemente->fetch(PDO::FETCH_ASSOC);
                  
                  session_start();
                  $_SESSION["user"] = $user;

                  header("Location: home.php");
            }
        }
    }
?>

<?php require "partial/header.php" ?>

  <div class="container pt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>
          <div class="card-body">
            <?php if ($error): ?>
              <p class="text-danger">
                <?= $error ?>
              </p>
            <?php endif ?>
            <form method="POST" action="register.php">
              <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
  
                <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                </div>
              </div>
  
              <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
  
                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus>
                </div>
              </div>

              <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
  
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
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
<?php require "partial/footer.php" ?>