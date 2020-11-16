<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)&& isset($_POST['username']) && isset($_POST['password'])){
  if(isset($_POST['username'])&&isset($_POST['password'])){
  // username
  if($username == "Admin"){
    $error .= "illegal";
  }
  if(!empty(trim($_POST['username']))){

    $username = trim($_POST['username']);

    // prüfung benutzername
    if(!preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{5,}/", $username) || strlen($username) > 30){
      $error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
    }
  } else {
    $error .= "Geben Sie bitte den Benutzername an.<br />";
  }
  // password

  if(!empty(trim($_POST['password']))){
    $password = trim($_POST['password']);
    // passwort gültig?
    if(!preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)){
      $error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
    }
  }else {
    $error .= "Geben Sie bitte das Passwort an.<br />";
  }

  // kein fehler
  if(empty($error)){
    // query
    $query = "SELECT username, password from users where username = ?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if($stmt===false){
      $error .= 'prepare() failed '. $mysqli->error . '<br />';
    }
    // parameter an query binden
    if(!$stmt->bind_param("s", $username)){
      $error .= 'bind_param() failed '. $mysqli->error . '<br />';
    }
    // query ausführen
    if(!$stmt->execute()){
      $error .= 'execute() failed '. $mysqli->error . '<br />';
    }
    //Session

    // daten auslesen
    $result = $stmt->get_result();
    // benutzer vorhanden
    if($result->num_rows){
      // userdaten lesen
      $row = $result->fetch_assoc();
      // passwort prüfen
      $passwordhash = password_verify($password,$row['password']);

      if($passwordhash == true){
         $message .= "Sie sind nun eingeloggt";
        $_SESSION['text'] = "";
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        ?><script> window.location.href = 'index.php'; </script><?php

        if($passwordhash == true && $username=="Admin"){

          $_SESSION['Admin']= true;
          ?><script> window.location.href = 'index.php'; </script><?php
        }
      } else {
        $error .= "Benutzername oder Passwort sind falsch";
        echo '<span style="color:red;">'.$error.'</span>';
        ?><script> window.location.href = 'index.php#contact'; </script><?php
      }
    }
  }
}
}
?>
