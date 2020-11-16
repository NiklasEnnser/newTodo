<!DOCTYPE HTML>
<?php session_start(); session_regenerate_id(); ?>
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
<html>
	<head>
		<title>Todo's </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="icon"
      type="image/png"
      href="images/todo.png">
		<script src="https://kit.fontawesome.com/840b82b233.js" crossorigin="anonymous"></script>
	</head>
	<body>

<div style="margin:20%;">
<h1><i class="fa fa-archive"></i>&nbsp; Archive</h1>
<?php

  $queryarchive = "SELECT * FROM todo WHERE isArchived=1 ORDER BY priority DESC";
  $stmtarchive = $mysqli->prepare($queryarchive);
  $bool = $stmtarchive->execute();
  $resultarchive = $stmtarchive->get_result();
  while($rowarchive = $resultarchive->fetch_assoc()){if($rowarchive['title']){echo
                                                '<h1 class="mitte">'.$rowarchive['title'].'</h1>'.
                                                '<p class="fliesstext mitte">'.$rowarchive['inhalt'].'</p>'.
                                                '<p class="fliesstext mitte">'."Todo erstellt am: ".$rowarchive['eDatum'].'</p>'.
                                                '<p class="fliesstext mitte">'."Zu erledigen bis: ".$rowarchive['aDatum'].'</p>'.
                                                '<p class="fliesstext mitte">'."ID der Todo: ".'<b>'.$rowarchive['todo_ID'].'</b>'.'</p>'.
                                                '<div class="panel__block"></div>'
                                                ;}}
  $resultarchive->free();
  $stmtarchive->close();

?>
</div>

<footer style="margin: 20%">
  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="funktionherstellen"> Todo wieder herstellen: </label>
      <input type="text" name="titleHerstellen" class="form-control" id="title"
          value=""
          placeholder="geben Sie eine ID ein!"
          pattern="(?=.*[0-9]){1,}"
          title="Es können nur Zahlen eingegeben werden"
          maxlength="30" required="true"/></div>
          <div class="float">
      <p><button type="submit" class="fa fa-undo none c-5 b-yellow" name="funktionherstellen" value="" /></button></p>
    </div>
  </div>
  </form>
  <?php
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['funktionherstellen']) and isset($_POST['titleHerstellen'])){
    $DsHerstellen = htmlspecialchars(trim($_POST['titleHerstellen']));

    $queryZI = "SELECT user_ID FROM todo WHERE todo_ID =? ";
    $stmtZI = $mysqli->prepare($queryZI);
    $stmtZI->bind_param('i', $DsHerstellen);
    $bool = $stmtZI->execute();
    $resultZI = $stmtZI->get_result();
    while($rowZI = $resultZI->fetch_assoc()){$_SESSION['UZID']=$rowZI['user_ID']; };
    $resultZI->free();
    $stmtZI->close();

    if($_SESSION['usernameID']==$_SESSION['UZID']){

    $queryL = "UPDATE todo SET isArchived = 0 WHERE todo_ID = ?";
    $stmtL = $mysqli->prepare($queryL);
    $stmtL->bind_param("i",$DsHerstellen);
    $bool = $stmtL->execute();
    $stmtL->close();
    ?><script> window.location.href = 'Anzeige.php'; </script><?php
  }elseif($_SESSION['usernameID']==7){
		$queryL = "UPDATE todo SET isArchived = 0 WHERE todo_ID = ?";
		$stmtL = $mysqli->prepare($queryL);
		$stmtL->bind_param("i",$DsHerstellen);
		$bool = $stmtL->execute();
		$stmtL->close();
		?><script> window.location.href = 'Anzeige.php'; </script><?php
	}else{ echo '<p class="c-5">'.'<b>'."Sie sind nicht der Ersteller dieser Todo!".'</b>'.'</p>';}
  }?>
</footer>

<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-9bf952ccbbd13c245169a0a1190323a27ce073a3d304b8c0fdf421ab22794a58.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script id="rendered-js" src="main.js"></script>
</body>
</html>
