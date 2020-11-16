<?php



// Wurden Daten mit "POST" gesendet?
if($_SERVER['REQUEST_METHOD'] == "POST"&&isset($_POST['e_username'])&&isset($_POST['e_password'])){
  // Ausgabe des gesamten $_POST Arrays

  // benutzername vorhanden, mindestens 6 Zeichen und maximal 30 zeichen lang
  if(isset($_POST['e_username']) && !empty(trim($_POST['e_username'])) && strlen(trim($_POST['e_username'])) <= 30){
    $e_username = trim($_POST['e_username']);
    // entspricht der benutzername unseren vogaben (minimal 6 Zeichen, Gross- und Kleinbuchstaben)
    if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}/", $e_username)){
      $error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
    }
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte einen korrekten Benutzernamen ein.<br />";
  }
    if($username == "Admin"){
    $error .= "Geben Sie bitte einen korrekten Benutzernamen ein.<br />";
    }
  // passwort vorhanden, mindestens 8 Zeichen
  if(isset($_POST['e_password']) && !empty(trim($_POST['e_password']))){
    $e_password = trim($_POST['e_password']);
    //entspricht das passwort unseren vorgaben? (minimal 8 Zeichen, Zahlen, Buchstaben, keine Zeilenumbrüche, mindestens ein Gross- und ein Kleinbuchstabe)
    if(!preg_match("/(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $e_password)){
      $error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
    }
  } else {
    // Ausgabe Fehlermeldung
    $error .= "Geben Sie bitte korrekte Daten ein.<br />";
  }
  if(isset($_POST['e_username'])){
  $queryuhk = "SELECT username FROM users";
  $stmtuhk = $mysqli->prepare($queryuhk);
  $booluhk = $stmtuhk->execute();
  $resultuhk = $stmtuhk->get_result();
  while($rowuhk = $resultuhk->fetch_assoc()){
    if($_POST['e_username']==$rowuhk['username']){
      $error = "Benutzername vergeben!";
    }
  }
  $resultuhk->free();
  $stmtuhk->close();
}
  // wenn kein Fehler vorhanden ist, schreiben der Daten in die Datenbank

  if(empty($error)){
    $e_passwordhash= password_hash($e_password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (username, password) VALUES(?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ss', $e_username, $e_passwordhash);
    $bool = $stmt->execute();
    $stmt->close();
    $_SESSION['e_username']=$e_username;
    $e_password = $e_username = '';
    $_SESSION['registriert']=true;
    echo '<span style="color:green;">'."User wurde erfolgreich erstellt!".'</span>';
    ?><script> window.location.href = 'Index.php#contact'; </script><?php
  }else{
    echo '<span style="color:red;">'.$error.'</span>';  }
  }


?>
