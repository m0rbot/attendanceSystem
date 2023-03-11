<?php
session_start();

if(!isset($_SESSION['email']))
{
    header("location: login.php");
}
if(isset($_POST['logout'])){
  session_unset();
  session_destroy();
  header("location: login.php");
}
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
if(isset($_POST['submit'])){
  $table = $_POST['class'];
  $l_name = $_POST['l_name'];
  $f_name = $_POST['f_name'];
  $code = $_POST['code'];

  $query = "SELECT * FROM $table WHERE nom = :l_name AND prenom = :f_name OR apoge = :code ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":l_name", $l_name);
    $stmt->bindParam(":f_name", $f_name);
    $stmt->bindParam(":code", $code);
    $stmt->execute();
    $result = $stmt->fetch();

    if(!$result){
      $query = "INSERT INTO  $table (apoge, nom, prenom, heure_dabsence) VALUES ('$code', '$l_name', '$f_name', 0)";
      $stmt = $conn->prepare($query);
      $stmt->execute();
      echo "<div id=\"success\" class=\"alert alert-success\" role=\"alert\" style=\"width:40%;margin-left:30%;position:absolute;z-index:9; margin-top:12%;\">Etudiant ajouté avec succès <span id=\"close\" onclick=\"document.getElementById('success').remove();\">x</span></div>";
    }else{
      echo "<div id=\"fail\" class=\"alert alert-danger\" role=\"alert\" style=\"width:40%;margin-left:30%;position:absolute;z-index:9; margin-top:12%;\">Veulliez ressayer s'il vous plait. Etudiant existe deja<span id=\"close\" onclick=\"document.getElementById('fail').remove();\">x</span></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/est_logo_favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/all.css">
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/jquery-ui.min.js" type="text/javascript"></script>
  <title>Home</title>
</head>
<body>

  <nav class="navbar bg-body-tertiary">
    <div class="container">
      <a class="navbar-brand" href="https://www.est.um5.ac.ma/" target="_blank">
        <img src="img/est_logo.png" alt="Ecole superieure de technologie de Salé" width="300" height="50">
      </a>
      <form method="post"><button class="btn btn-warning logout" name="logout" type="submit">Se déconnecter</button></form>
    </div>
  </nav>

  <button type="button" class="btn btn-outline-secondary" id="ajt">Ajouter un étudiant</button>
  <button type="button" class="btn btn-outline-secondary" id="sch">Emplois du temps</button>
  <button type="button" class="btn btn-outline-secondary" id="lst">List d'absence</button>

  <div id="student">
    <form method="post" class="ajout">
      <div class="row mb-4">
        <div class="col">
          <div class="form-outline">
            <label class="form-label" for="form3Example1">Prénom</label>
            <input name="f_name" type="text" id="form3Example1" class="form-control" required/>
          </div>
        </div>
        <div class="col">
          <div class="form-outline">
            <label class="form-label" for="form3Example2">Nom</label>
            <input name="l_name" type="text" id="form3Example2" class="form-control" required/>
          </div>
        </div>
      </div>
      <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Code apogé</label>
        <input name="code" type="text" id="form3Example3" class="form-control" required/>
      </div>

      <div>
          <label class="form-label" for="form3Example4">Filière</label>
          <select name="class" class="form-select">
            <option selected>choose...</option>
            <option value="geii">GEII</option>
            <option value="gim">GIM</option>
          </select>
      </div>
      <div class="form-outline mb-4">
        <label class="form-label" for="form3Example5">Empreint</label>
        <div class="input-group">
          <input type="text" id="form3Example4" class="form-control" required/>
          <button name="finger" type="button" class="btn btn-outline-success" id="fingerprint">Inscrire l'empreint</button>
        </div>

      </div>
      <button name="submit" type="submit" class="btn btn-success btn-block mb-4">Enregistrer</button>
      </form>
  </div>
  <div id="schedule">
  <div id="classSel">
    <label class="form-label">Filière</label>
    <select name="fil_schedule" class="form-select">
      <option selected>Select...</option>
      <option value="geii">GEII</option>
      <option value="gim">GIM</option>
    </select>
  </div>
  <div id="date" class="form-outline datepicker">
    <label class="form-label">Date du cours</label>
    <input type="date" id="datepicker" class="datepicker form-control">
  </div>
  <div id="time">
  <div id="startTime" class="form-outline datepicker">
    <label class="form-label">Depart du cours</label>
    <input type="time" id="start" class="datepicker form-control">
  </div>
  <div id="endTime" class="form-outline datepicker">
  <label class="form-label">fin du cours</label>
    <input type="time" id="end" class="datepicker form-control">
  </div>
</div>
  <div id="subjectSel">
    <label class="form-label">Matière</label>
    <select name="subjectSel" class="form-select">
      <option selected>Select...</option>
      <option value="geii">Mati1</option>
      <option value="gim">Mati2</option>
    </select>
  </div>
  <form class="upload" methode="post"><button name="uploadSchedule" type="button" class="btn btn-success">Ajouter</button></form>
  </div>

  <div class="list" id="abs">
    <div class="cont_ainer">
      <div class="select_fil">
        <select id="fil" name="filiere" class="form-select">
          <option selected>Filière...</option>
          <option value="geii">GEII</option>
          <option value="gim">GIM</option>
        </select>
      </div>
      <div class="input-group rech">
        <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
        <button name="searchBtn" type="button" class="btn btn-outline-success rounded">search</button>
      </div>
    </div>

    <div id="geii_data" class="database" style="display:none;">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">apogé</th>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Heure d'absence</th>
          </tr>
        </thead>
        <tbody>
        <?php
        try {
          $servername = "localhost:3306";
          $dbname = "attendance";
          $username = "anouar";
          $password = "anouar";

          $pdo = new PDO("mysql:host=$servername;dbname=attendance", $username, $password);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $geii_data = $pdo->query("SELECT * FROM geii");
          $show_geii_data = $geii_data->fetchAll(PDO::FETCH_ASSOC);
          for($i = 0; $i < count($show_geii_data); $i++){
            echo "<tr";
            if($i % 2 == 0){
              echo " class='table-active'";
            }
            echo ">";
            echo "<td>".$show_geii_data[$i]['id']."</td>";
            echo "<td>".$show_geii_data[$i]['apoge']."</td>";
            echo "<td>".$show_geii_data[$i]['nom']."</td>";
            echo "<td>".$show_geii_data[$i]['prenom']."</td>";
            echo "<td>".$show_geii_data[$i]['heure_dabsence']."h</td>";
            echo "</tr>";
          }
        } catch (PDOException $e) {
          echo "Error: " . $e->getMessage();
        }
        ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="js/bootstrap.js" type="text/javascript"></script>
  <script src="js/app.js" type="text/javascript"></script>


</body>
</html>
