<?php
//users_has_kategorie Tabellenabfrage
$queryKategorie = "SELECT kategorie.name, users.username, users.user_ID
                    FROM users
                    LEFT JOIN users_has_kategorie ON users_has_kategorie.user_ID = users.user_ID
                    LEFT JOIN kategorie ON users_has_kategorie.kategorie_ID = kategorie.kategorie_ID
                    WHERE users.user_ID = users_has_kategorie.user_ID AND kategorie.kategorie_ID = users_has_kategorie.kategorie_ID";

$stmtKategorie = $mysqli->prepare($queryKategorie);
$bool = $stmtKategorie->execute();
$resultKategorie = $stmtKategorie->get_result();
echo '<p class="top">'."User has Kategorie: ".'</p>'.'<table>'.'<tr>'.'<th>'."userID: ".'</th>'.'<th>'."username: ".'</th>'.'<th>'."Kategoriename: ".'</th>'.'</tr>';
while($rowKategorie = $resultKategorie->fetch_assoc()){if($rowKategorie['user_ID']){echo
                                              '<tr>'.'<td>'.$rowKategorie['user_ID'].'</td>'.
                                              '<td>'.$rowKategorie['username'].'</td>'.
                                              '<td>'.$rowKategorie['name'].'</td>'.'</tr>'
                                              ;}} echo '</table>'.'<div class="panel__block"></div>';
$resultKategorie->free();
$stmtKategorie->close();
//User Tabellen Abfrage
$queryUsers = "SELECT user_ID, username FROM users ";
$stmtUsers = $mysqli->prepare($queryUsers);
$bool = $stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();
echo '<p class="top">'."Users: ".'</p>'.'<table>'.'<tr>'.'<th>'."userID: ".'</th>'.'<th>'."username: ".'</th>'.'</tr>';
while($rowUsers = $resultUsers->fetch_assoc()){if($rowUsers['user_ID']){echo
                                              '<tr>'.'<td>'.$rowUsers['user_ID'].'</td>'.
                                              '<td>'.$rowUsers['username'].'</td>'.'</tr>'
                                              ;}} echo '</table>'.'<div class="panel__block"></div>';
$resultUsers->free();
$stmtUsers->close();

//Kategorien Tabelle Abfrage
$queryKategorien = "SELECT kategorie_ID, name FROM kategorie ";
$stmtKategorien = $mysqli->prepare($queryKategorien);
$bool = $stmtKategorien->execute();
$resultKategorien = $stmtKategorien->get_result();
echo '<p class="top">'."Kategorien: ".'</p>'.'<table>'.'<tr>'.'<th>'."Kategorie ID: ".'</th>'.'<th>'."Name: ".'</th>'.'</tr>';
while($rowKategorien = $resultKategorien->fetch_assoc()){if(isset($rowKategorien['kategorie_ID'])){echo
                                              '<tr>'.'<td>'.$rowKategorien['kategorie_ID'].'</td>'.
                                              '<td>'.$rowKategorien['name'].'</td>'.'</tr>'
                                              ;}} echo '</table>'.'<div class="panel__block"></div>';
$resultKategorien->free();
$stmtKategorien->close();

//neue Kategorie erstellen
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Kategorieerstellen']) and isset($_POST['Kategorienameerstellen'])){
    $Kne = htmlspecialchars(trim($_POST['Kategorienameerstellen']));

    $queryE = "INSERT INTO kategorie (name) VALUES (?)";
    $stmtE = $mysqli->prepare($queryE);
    $stmtE->bind_param("s",$Kne);
    $bool = $stmtE->execute();
    $stmtE->close();
    ?><script> window.location.href = 'Admin.php'; </script><?php
}
//Kategorie löschen
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Kategorielöschen']) and isset($_POST['Kategorienamelöschen'])){
    $Knl = htmlspecialchars(trim($_POST['Kategorienamelöschen']));

    $queryL = "DELETE FROM kategorie WHERE kategorie_ID = ?";
    $stmtL = $mysqli->prepare($queryL);
    $stmtL->bind_param("i",$Knl);
    $bool = $stmtL->execute();
    $stmtL->close();
    ?><script> window.location.href = 'Admin.php'; </script><?php
}
//Kategorie Zuweisung entfernen
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['DeleteKategorie']) and isset($_POST['DeleteKategorieUser']) and isset($_POST['DeleteKategorieKategorie'])){
    $DKU = htmlspecialchars(trim($_POST['DeleteKategorieUser']));
    $DKK = htmlspecialchars(trim($_POST['DeleteKategorieKategorie']));

    $queryDK = "DELETE FROM users_has_kategorie WHERE user_ID = ? AND kategorie_ID = ?";
    $stmtDK = $mysqli->prepare($queryDK);
    $stmtDK->bind_param("ii",$DKU, $DKK);
    $bool = $stmtDK->execute();
    $stmtDK->close();
    ?><script> window.location.href = 'Admin.php'; </script><?php
}
//Kategorie zuweisen neu
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Userkategorie']) and isset($_POST['ChangeKatergorieID']) and isset($_POST['ChangeUserID'])){
  $CKID = htmlspecialchars(trim($_POST['ChangeKatergorieID']));
  $CUID = htmlspecialchars(trim($_POST['ChangeUserID']));

  $queryZ = "INSERT INTO users_has_kategorie (user_ID, kategorie_ID) VALUES (?,?)";
  $stmtZ = $mysqli->prepare($queryZ);
  $stmtZ->bind_param("ii",$CUID , $CKID);
  $bool = $stmtZ->execute();
  $stmtZ->close();
  ?><script> window.location.href = 'Admin.php'; </script><?php
}

//neue Benutzer erstellen
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Benutzererstellen']) and isset($_POST['Benutzernameerstellen']) and isset($_POST['Benutzerpassword'])){
    $Bpee = $_POST['Benutzerpassword'];
    $Bne = htmlspecialchars(trim($_POST['Benutzernameerstellen']));
    $Bpe= password_hash($Bpee, PASSWORD_DEFAULT);

    $queryBE = "INSERT INTO users (username, password) VALUES(?, ?)";
    $stmtBE = $mysqli->prepare($queryBE);
    $stmtBE->bind_param('ss', $Bne, $Bpe);
    $bool = $stmtBE->execute();
    $stmtBE->close();
    ?><script> window.location.href = 'Admin.php'; </script><?php
}

//Benutzer löschen
  if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['Benutzerlöschen']) and isset($_POST['BenutzerIDlöschen'])){
    $BIDL = $_POST['BenutzerIDlöschen'];

    $queryL = "DELETE FROM users WHERE user_ID = ?";
    $stmtL = $mysqli->prepare($queryL);
    $stmtL->bind_param("i",$BIDL);
    $bool = $stmtL->execute();
    $stmtL->close();
    ?><script> window.location.href = 'Admin.php'; </script><?php
}
?>
