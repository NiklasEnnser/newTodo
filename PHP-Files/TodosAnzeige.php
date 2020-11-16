<?php


$queryUsername = "SELECT user_ID FROM users WHERE username = ? ";
$stmtUsername = $mysqli->prepare($queryUsername);
$stmtUsername->bind_param('s', $_SESSION['username']);
$bool = $stmtUsername->execute();
$resultUsername = $stmtUsername->get_result();
while($rowUsername = $resultUsername->fetch_assoc()){ $_SESSION['usernameID']= $rowUsername['user_ID'];};
$resultUsername->free();
$stmtUsername->close();
if($_SESSION['usernameID']==7){
  $querytodo = "SELECT todo.*
  FROM todo, kategorie
      LEFT JOIN users_has_kategorie ON users_has_kategorie.kategorie_ID = kategorie.kategorie_ID
      LEFT JOIN users ON  users.user_ID = users_has_kategorie.user_ID
      WHERE todo.isArchived=0
      AND todo.kategorie = kategorie.name
      ORDER BY todo.priority DESC, todo.aDatum ASC
      LIMIT $start, $count";
  $stmttodo = $mysqli->prepare($querytodo);
  $bool = $stmttodo->execute();
  $resulttodo = $stmttodo->get_result();
}else{
$querytodo = "SELECT todo.*
FROM todo, kategorie
    LEFT JOIN users_has_kategorie ON users_has_kategorie.kategorie_ID = kategorie.kategorie_ID
    LEFT JOIN users ON  users.user_ID = users_has_kategorie.user_ID
    WHERE todo.isArchived=0
    AND users_has_kategorie.user_ID = ?
    AND kategorie.kategorie_ID = users_has_kategorie.kategorie_ID
    AND todo.kategorie = kategorie.name
    ORDER BY todo.priority DESC, todo.aDatum ASC
    LIMIT $start, $count";
$stmttodo = $mysqli->prepare($querytodo);
$stmttodo->bind_param("i", $_SESSION['usernameID']);
$bool = $stmttodo->execute();
$resulttodo = $stmttodo->get_result();
}


while($row = $resulttodo->fetch_assoc()){
if($row['priority']==5){
  echo '<div class="media all 5">'.'<img src="images/thumbs/5.png" /><div class="Kasten">';}
elseif($row['priority']==4){
  echo '<div class="media all 4">'.'<img src="images/thumbs/4.png" /><div class="Kasten">';}
elseif($row['priority']==3){
  echo '<div class="media all 3">'.'<img src="images/thumbs/3.png" /><div class="Kasten">';}
elseif($row['priority']==2){
  echo '<div class="media all 2">'.'<img src="images/thumbs/2.png" /><div class="Kasten">';}
elseif($row['priority']==1){
  echo '<div class="media all 1">'.'<img src="images/thumbs/1.png" /><div class="Kasten">';}
  echo'<h1 style="color: black;font-size:250%;margin:0px;text-align:center;" class="mitte">'.$row['title'].'</h1>'.
     '<p style="color: black;">'.$row['inhalt'].'</p>'.
      //'<p class="fliesstext mitte">'."Todo erstellt am: ".$row['eDatum'].'</p>'.
      '<span style="color: black;">'."Zu erledigen bis: ".$row['aDatum'].'<br>';?>
<SCRIPT language=JavaScript type=text/javascript>
var aDatum ='<?php echo $row['aDatum']; ?>';
var ausgangsdatum=new Date();
var heute=new Date(aDatum);
var tag=1000*60*60*24;
var differenz=Math.ceil((heute.getTime()-ausgangsdatum.getTime())/(tag));
if(differenz > 0){
document.write("Tage Zeit: <span style=\"color:green;font-size: 1em; padding: 5px; font-family:arial, helvetica, sans-serif;\">" + differenz + "<\/span>"+'</\span>');}
if(differenz < 0){
document.write("Tage Zeit: <span style=\"color:red;font-size: 1em; padding: 5px; font-family:arial, helvetica, sans-serif;\">" + differenz + "<\/span>"+'</\span>');}
if(differenz == 0){
document.write("Tage Zeit: <span style=\"color:yellow;font-size: 1em; padding: 5px; font-family:arial, helvetica, sans-serif;\">" + differenz + "<\/span>"+'</\span>');}

</SCRIPT>
                              <?php    echo '<br>'.'<span style="color: black;" class="fliesstext mitte">'."Kategorie: ".$row['kategorie']."</span>".
                                              '</div>'.'</a>'.'</div>'
                                              ;}

$resulttodo->free();
$stmttodo->close();




?>
