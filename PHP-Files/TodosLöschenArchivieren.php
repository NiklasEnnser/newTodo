<?php
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['funktionLöschen'])and isset($_POST['titleLöschen'])){
  $DsLöschen = htmlspecialchars(trim($_POST['titleLöschen']));

  $queryUL = "SELECT user_ID FROM todo WHERE todo_ID =? ";
  $stmtUL = $mysqli->prepare($queryUL);
  $stmtUL->bind_param('i', $DsLöschen);
  $bool = $stmtUL->execute();
  $resultUL = $stmtUL->get_result();
  while($rowUL = $resultUL->fetch_assoc()){$_SESSION['ULID']=$rowUL['user_ID']; };
  $resultUL->free();
  $stmtUL->close();

  if($_SESSION['usernameID']==$_SESSION['ULID']){
  $queryL = "DELETE FROM todo WHERE todo_ID=?";
  $stmtL = $mysqli->prepare($queryL);
  $stmtL->bind_param("i",$DsLöschen);
  $bool = $stmtL->execute();
  $stmtL->close();
  ?><script> window.location.href = 'Anzeige.php'; </script><?php
}elseif($_SESSION['usernameID']==7){
    $queryL = "DELETE FROM todo WHERE todo_ID=?";
    $stmtL = $mysqli->prepare($queryL);
    $stmtL->bind_param("i",$DsLöschen);
    $bool = $stmtL->execute();
    $stmtL->close();
    ?><script> window.location.href = 'Anzeige.php'; </script><?php
}else{ echo '<p>'.'<b>'."Sie sind nicht der Ersteller dieser Todo!".'</b>'.'</p>';}
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['funktionArchivieren']) and isset($_POST['titleArchive'])){
  $DsArchive = htmlspecialchars(trim($_POST['titleArchive']));

  $queryUA = "SELECT user_ID FROM todo WHERE todo_ID =? ";
  $stmtUA = $mysqli->prepare($queryUA);
  $stmtUA->bind_param('i', $DsArchive);
  $bool = $stmtUA->execute();
  $resultUA = $stmtUA->get_result();
  while($rowUA = $resultUA->fetch_assoc()){$_SESSION['UAID']=$rowUA['user_ID']; };
  $resultUA->free();
  $stmtUA->close();

  if($_SESSION['usernameID']==$_SESSION['UAID']){

  $queryL = "UPDATE todo SET isArchived = 1 WHERE todo_ID = ?";
  $stmtL = $mysqli->prepare($queryL);
  $stmtL->bind_param("i",$DsArchive);
  $bool = $stmtL->execute();
  $stmtL->close();
  ?><script> window.location.href = 'Anzeige.php'; </script><?php

}elseif($_SESSION['usernameID']==7){
  $queryL = "UPDATE todo SET isArchived = 1 WHERE todo_ID = ?";
  $stmtL = $mysqli->prepare($queryL);
  $stmtL->bind_param("i",$DsArchive);
  $bool = $stmtL->execute();
  $stmtL->close();
  ?><script> window.location.href = 'Anzeige.php'; </script><?php
}
  else{ echo '<p class="c-5">'.'<b>'."Sie sind nicht der Ersteller dieser Todo!".'</b>'.'</p>';}
}
if(isset($_POST['Archiveredoid'])&&isset($_POST['ArchiveRedo'])){

$DsArchive = $_POST['Archiveredoid'];
$queryL = "UPDATE todo SET isArchived = 0 WHERE todo_ID = ?";
$stmtL = $mysqli->prepare($queryL);
$stmtL->bind_param("i",$DsArchive);
$bool = $stmtL->execute();
$stmtL->close();
?><script> window.location.href = 'Anzeige.php'; </script><?php

}
?>
