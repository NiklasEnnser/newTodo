<?php
$error = '';
if($_SERVER['REQUEST_METHOD'] == "POST"&&isset($_POST['title'])&&isset($_POST['text'])&&isset($_POST['Submit'])){
  // Ausgabe des gesamten $_POST Arrays
  // Titel vorhanden, mindestens 1 Zeichen und maximal 30 Zeichen lang
  if(isset($_POST['title']) && !empty(trim($_POST['title'])) && strlen(trim($_POST['title'])) <= 30){
    // Spezielle Zeichen Escapen > Script Injection verhindern
    $title = htmlspecialchars(trim($_POST['title']));
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte einen korrekten Vornamen ein.<br />";
  }

  // Text
    // Spezielle Zeichen Escapen > Script Injection verhindern
    $text = htmlspecialchars(trim($_POST['text']));

  // emailadresse vorhanden, mindestens 1 Zeichen und maximal 30 zeichen lang
  if(isset($_POST['kategorie']) && !empty(trim($_POST['kategorie'])) && strlen(trim($_POST['kategorie'])) <= 30){
    $kategorie = htmlspecialchars(trim($_POST['kategorie']));
    $_POST['kategorie']="";
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte eine korrekte Email-Adresse ein.<br />";
  }

  // deadline vorhanden, mindestens 6 Zeichen und maximal 30 zeichen lang
  if(isset($_POST['deadline'])){
    $deadline = $_POST['deadline'];

  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte einen korrekten Benutzernamen ein.<br />";
  }
  if(isset($_POST['priority'])){
    $priority = $_POST['priority'];
  } else {
    // Ausgabe Fehlermeldung
    $error .= "...";
  }

$isArchived = "0";
if (isset($error)){}

  if(empty($error)){

    $queryabfrage = "SELECT user_ID FROM users WHERE username = ?";
    $stmtabfrage = $mysqli->prepare($queryabfrage);
    $stmtabfrage ->bind_param("s", $_SESSION['username']);
    $stmtabfrage->execute();
    $result = $stmtabfrage->get_result();
    $user_ID = $result->fetch_assoc()['user_ID']; // Joshua
    $result->free();
    $stmtabfrage->close();


    $aktuellesDatum = date("Y-m-d");
    $queryte = "INSERT INTO todo (title, inhalt, kategorie, eDatum, aDatum, user_ID, priority, isArchived) VALUES (?,?,?,?,?,?,?,?)";
    $stmtte = $mysqli->prepare($queryte);
    $stmtte->bind_param("sssssiii",$title, $text, $kategorie,$aktuellesDatum, $deadline,$user_ID, $priority , $isArchived);
    $bool = $stmtte->execute();
    $stmtte->close();
    $title= $text= $kategorie= $aktuellesDatum=$username= $deadline= $priority= $isArchived ='';
    ?>
    <script>window.location.href = 'Anzeige.php';</script>
    <?php
}
}
 ?>
