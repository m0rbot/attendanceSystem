<?php
session_start();
try {
  $servername = "localhost:3306";
  $dbname = "attendance";
  $username = "anouar";
  $password = "anouar";

  $conn = new PDO("mysql:host=$servername; dbname=attendance",$username, $password);

 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST["submit"])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM administration WHERE email=:email AND password=:password");
    $query->execute(array(':email' => $email,':password' => $password));

    if($query->rowCount() == 1){
      $_SESSION['email'] = $email;
      $_SESSION['logged_in'] = true;
      header("location: index.php");
    }else{
      echo "<div id=\"icorrectCred\" class=\"alert alert-danger\" role=\"alert\" style=\"width:30%;margin-left:33%;position:absolute;z-index:9; margin-top:7%;\">Email/password incorrect Veulliez ressayer s'il vous plait <span id=\"close\" onclick=\"document.getElementById('icorrectCred').remove();\">x</span></div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/est_logo_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    </head>
    <nav class="navbar bg-body-tertiary">
        <div class="container">
          <a class="navbar-brand" href="https://www.est.um5.ac.ma/" target="_blank">
            <img src="img/est_logo.png" alt="Ecole superieure de technologie de Salé" width="300" height="50">
          </a>
        </div>
      </nav>
    <form class="login" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input name="password" type="password" class="form-control" id="exampleInputPassword1" required>
        </div>
        <button name="submit" type="submit" class="btn btn-success">Submit</button>
      </form>
        <script src="js/bootstrap.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>

