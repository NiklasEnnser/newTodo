<!DOCTYPE html><?php
session_start();
session_regenerate_id(); ?>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
<meta name="apple-mobile-web-app-title" content="CodePen">
<title>Gaming News</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel="stylesheet" href="main.css">
<script src="https://kit.fontawesome.com/840b82b233.js" crossorigin="anonymous"></script>
<?php
// Initialisierung
$username = '';
$host     = 'localhost'; // host
$usernameAnmeldung = 'root'; // username
$anmeldungpassword = ''; // password (brauchen Sie nie dieses Passwort, ich erkläre später warum)
$database = 'phpprojekt'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host, $usernameAnmeldung,$anmeldungpassword, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

$error = '';
$message = '';
?>

</head>
<body>

<section style="margin: 10%;">


<h1 class="panel__headline mitte"><i class="fa fa-comment"></i>&nbsp; Todo's Bearbeiten</h1>

<div class="panel__block"></div>

<?php
if(isset($_POST['titleBearbeiten'])){
$_SESSION['soeineScheisse']=$_POST['titleBearbeiten'];}
$queryBUID = "SELECT user_ID FROM users WHERE username = ?";
$stmtBUID= $mysqli->prepare($queryBUID);
$stmtBUID ->bind_param("s", $_SESSION['username']);
$stmtBUID->execute();
$resultBUID = $stmtBUID->get_result();
$user_BUID = $resultBUID->fetch_assoc()['user_ID']; // Joshua
$resultBUID->free();
$stmtBUID->close();


if($_SESSION['usernameID']==7){
  $TodoIDB = $_POST['titleBearbeiten'];
  $queryTB = "SELECT *
  FROM todo WHERE todo_ID = ?";
  $stmtTB = $mysqli->prepare($queryTB);
  $stmtTB->bind_param("i",$TodoIDB);
  $bool = $stmtTB->execute();
  $resultTB = $stmtTB->get_result();
  while($rowTB = $resultTB->fetch_assoc()){
  echo
    '<form action="Update.php" method="POST">
      <div class="form-group">
      <label for="title">Titel:</label>
      <input type="text" name="Bearbeitentitle" class="form-control" id="title"
          value="'.$rowTB['title'].'"
          placeholder="geben Sie einen Titel ein!"
          maxlength="30" required="true"
          title="Gross- und Keinbuchstaben, min 1 Zeichen.">
      </div>
      <div class="form-group">
      <label for="text">Text:</label>
      <textarea type="text" name="Bearbeitentext" class="form-control" id="text" rows="10" cols="50"
          placeholder="geben Sie einen Text ein!">'.$rowTB['inhalt'].'</textarea>
      </div>
      <!-- Kategorie -->
      <div class="form-group">
        <label for="deadline">Kategorie:</label>
        <select name="Bearbeitenkategorie" class="" id="kategorie" required="true">
        <option value="'.$rowTB['kategorie'].'">'.$rowTB['kategorie'].'</option>';include('PHP-Files/KategorienAbfrage.php');echo'</select>
      </div>
      <div class="form-group">
        <label for="deadline">Deadline</label>
        <input type="date" name="Bearbeitendeadline" class="datepicker" data-date-format="mm/dd/yyyy" id="deadline" value="'.$rowTB['aDatum'].'"
            required="true">
      </div>
      <div class="form-group">
        <label for="priority">Priority: </label>
        <select name="Bearbeitenpriority" class="" id="kategorie"
            required="true">
            <option value="'.$rowTB['priority'].'">'.$rowTB['priority'].'</option>
            <option value=1>1</option>
             <option value=2>2</option>
              <option value=3>3</option>
               <option value=4>4</option>
                <option value=5>5</option>
          </select>
      </div>
        <button type="submit" name="BearbeitenSubmit" value="submit" class="btn btn-info">Bearbeiten</button>

    </form>';

  }

}else{
if(isset($_POST['titleBearbeiten'])){
$TodoIDB = $_POST['titleBearbeiten'];}
$queryTB = "SELECT todo.*
FROM todo, kategorie
    LEFT JOIN users_has_kategorie ON users_has_kategorie.kategorie_ID = kategorie.kategorie_ID
    WHERE todo.isArchived=0
    AND users_has_kategorie.user_ID = ?
    AND kategorie.kategorie_ID = users_has_kategorie.kategorie_ID
    AND todo.kategorie = kategorie.name
    AND todo.todo_ID = ?
    AND todo.user_ID = ?";
$stmtTB = $mysqli->prepare($queryTB);
$stmtTB->bind_param("iii",$user_BUID,$TodoIDB, $user_BUID);
$bool = $stmtTB->execute();
$resultTB = $stmtTB->get_result();
while($rowTB = $resultTB->fetch_assoc()){
echo
  '<form action="Update.php" method="POST">
    <div class="form-group">
    <label for="title">Titel:</label>
    <input type="text" name="Bearbeitentitle" class="form-control" id="title"
        value="'.$rowTB['title'].'"
        placeholder="geben Sie einen Titel ein!"
        maxlength="30" required="true"
        title="Gross- und Keinbuchstaben, min 1 Zeichen.">
    </div>
    <div class="form-group">
    <label for="text">Text:</label>
    <textarea type="text" name="Bearbeitentext" class="form-control" id="text" rows="4" cols="50"
        placeholder="geben Sie einen Text ein!">'.$rowTB['inhalt'].'</textarea>
    </div>
    <!-- Kategorie -->
    <div class="form-group">
      <label for="deadline">Kategorie:</label>
      <select name="Bearbeitenkategorie" class="" id="kategorie" required="true">
      <option value="'.$rowTB['kategorie'].'">'.$rowTB['kategorie'].'</option>';include('PHP-Files/KategorienAbfrage.php');echo'</select>
    </div>
    <div class="form-group">
      <label for="deadline">Deadline</label>
      <input type="date" name="Bearbeitendeadline" class="datepicker" data-date-format="mm/dd/yyyy" id="deadline" value="'.$rowTB['aDatum'].'"
          required="true">
    </div>
    <div class="form-group">
      <label for="priority">Priority: </label>
      <select name="Bearbeitenpriority" class="" id="kategorie"
          required="true">
          <option value="'.$rowTB['priority'].'">'.$rowTB['priority'].'</option>
          <option value=1>1</option>
           <option value=2>2</option>
            <option value=3>3</option>
             <option value=4>4</option>
              <option value=5>5</option>
        </select>
    </div>
      <button type="submit" name="BearbeitenSubmit" value="submit" class="btn btn-info">Bearbeiten</button>

  </form>';

}

  $resultTB->free();
  $stmtTB->close();
}
  if($_SERVER['REQUEST_METHOD'] == "POST"&&isset($_POST['Bearbeitentitle'])&&isset($_POST['Bearbeitentext'])&&isset($_POST['BearbeitenSubmit'])){
    // Ausgabe des gesamten $_POST Arrays


    // Titel vorhanden, mindestens 1 Zeichen und maximal 30 Zeichen lang
    if(isset($_POST['Bearbeitentitle']) && !empty(trim($_POST['Bearbeitentitle'])) && strlen(trim($_POST['Bearbeitentitle'])) <= 30){
      // Spezielle Zeichen Escapen > Script Injection verhindern
      $Bearbeitentitle = htmlspecialchars(trim($_POST['Bearbeitentitle']));

    }
echo '<p>'."hallo".'</p>';
    // Text
      // Spezielle Zeichen Escapen > Script Injection verhindern
      $Bearbeitentext = htmlspecialchars(trim($_POST['Bearbeitentext']));


    // kategorie vorhanden, mindestens 1 Zeichen und maximal 30 zeichen lang
    if(isset($_POST['Bearbeitenkategorie']) && !empty(trim($_POST['Bearbeitenkategorie'])) && strlen(trim($_POST['Bearbeitenkategorie'])) <= 30){
      $Bearbeitenkategorie = htmlspecialchars(trim($_POST['Bearbeitenkategorie']));
    }


    // deadline vorhanden, mindestens 6 Zeichen und maximal 30 zeichen lang
    if(isset($_POST['Bearbeitendeadline'])){
      $Bearbeitendeadline = $_POST['Bearbeitendeadline'];

    }

    if(isset($_POST['Bearbeitenpriority'])){
      $Bearbeitenpriority = $_POST['Bearbeitenpriority'];
    }

    if(empty($error)){

      $queryBB = "UPDATE todo SET
      title=?,
      inhalt=?,
      kategorie=?,
      aDatum=?,
      priority=?
      WHERE todo_ID =?";
      $stmtBB = $mysqli->prepare($queryBB);
      $stmtBB->bind_param("ssssii",$Bearbeitentitle, $Bearbeitentext, $Bearbeitenkategorie, $Bearbeitendeadline,$Bearbeitenpriority, $_SESSION['soeineScheisse']);
      $boolBB = $stmtBB->execute();
      $stmtBB->close();

      $Bearbeitentitle= $Bearbeitentext= $Bearbeitenkategorie= $Bearbeitendeadline=$Bearbeitenpriority= $TodoIDB='';
      ?>

      <script> window.location.href = '../Anzeige.php';</script>
      <?php


}
}

 ?>

</section>
<script>
$('.datepicker').datepicker({
  format: 'mm/dd/yyyy',
  startDate: '-3d'
 });
</script>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-9bf952ccbbd13c245169a0a1190323a27ce073a3d304b8c0fdf421ab22794a58.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script id="rendered-js" src="main.js"></script>
</body>
</html>
