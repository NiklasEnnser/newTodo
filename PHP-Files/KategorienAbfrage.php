<?php
//User Tabellen Abfrage
$queryabfrage2 = "SELECT user_ID FROM users WHERE username = ?";
$stmtabfrage2 = $mysqli->prepare($queryabfrage2);
$stmtabfrage2 ->bind_param("s", $_SESSION['username']);
$stmtabfrage2->execute();
$result2 = $stmtabfrage2->get_result();
$user_ID2 = $result2->fetch_assoc()['user_ID'];
$_SESSION['Kategorieuser_ID'] = $user_ID2;
$result2->free();
$stmtabfrage2->close();

if($_SESSION['usernameID']==7){
  $queryuhk = "SELECT name
                      FROM kategorie
                      ";

  $stmtuhk = $mysqli->prepare($queryuhk);
  $booluhk = $stmtuhk->execute();
  $resultuhk = $stmtuhk->get_result();
  while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['name'].'">'.$rowuhk['name'].'</option>';}
  $resultuhk->free();
  $stmtuhk->close();

}else{
//users_has_kategorie Tabellenabfrage
$queryuhk = "SELECT kategorie.name
                    FROM users
                    LEFT JOIN users_has_kategorie ON users_has_kategorie.user_ID = users.user_ID
                    LEFT JOIN kategorie ON users_has_kategorie.kategorie_ID = kategorie.kategorie_ID
                    WHERE users.user_ID = users_has_kategorie.user_ID AND kategorie.kategorie_ID = users_has_kategorie.kategorie_ID
                    AND users_has_kategorie.user_ID = ?";

$stmtuhk = $mysqli->prepare($queryuhk);
$stmtuhk->bind_param('i', $_SESSION['Kategorieuser_ID']);
$booluhk = $stmtuhk->execute();
$resultuhk = $stmtuhk->get_result();
while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['name'].'">'.$rowuhk['name'].'</option>';}
$resultuhk->free();
$stmtuhk->close();

}
 ?>
