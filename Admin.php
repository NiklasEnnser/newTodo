<?php
 session_start(); session_regenerate_id();
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
if($_SESSION['username']=="Admin"){
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
    <div class="page-wrap">
  <!-- Nav -->
    <nav id="nav">
      <ul>
        <li><a href="index.php" class="active"><span class="icon fa-home"></span></a></li>
        <li><a href="index.php#contact"><i class="fas fa-users"></i></a></li>
        <li><a href="Anzeige.php"><span class="icon fa-file-text-o"></span></a></li>
        <li><a href="Anzeige.php#contact"><i class="fas fa-file-upload"></i></a></li>
        <br><br>
        <li><a href="https://twitter.com/Mada_DV" target="_blank" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="#" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
        <li><a href="#" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
      </ul>
    </nav>



<div style="margin:5%;" class="social column">
<h1 class="panel__headline mitte"><i class="fas fa-cogs"></i>&nbsp; Adminsettings</h1>


  <?php
  include('PHP-Files/Adminsettings.php');
  ?><br><br><br><br><br>
    <button style="position: center; border-radius: 10px;" class="fa none b-orange" id="myBtn">Einstellungen</button>
</div>
</div>
<footer style="background-color: #EF932D;">


  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="DeleteKategorieUser"> User Kategorie entfernen </label>
        <select name="DeleteKategorieUser" class="" id="BenutzerIDlöschen"
            required="true">
            <option value="">Bitte auswählen... </option>
            <?php
              $queryuhk = "SELECT * FROM users";
              $stmtuhk = $mysqli->prepare($queryuhk);
              $booluhk = $stmtuhk->execute();
              $resultuhk = $stmtuhk->get_result();
              while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['user_ID'].'">'.$rowuhk['username'].'</option>';}
              $resultuhk->free();
              $stmtuhk->close();
            ?>
          </select>
          <select name="DeleteKategorieKategorie" class="" id="BenutzerIDlöschen"
              required="true">
              <option value="">Bitte auswählen... </option>
              <?php
                $queryuhk = "SELECT * FROM kategorie";
                $stmtuhk = $mysqli->prepare($queryuhk);
                $booluhk = $stmtuhk->execute();
                $resultuhk = $stmtuhk->get_result();
                while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['kategorie_ID'].'">'.$rowuhk['name'].'</option>';}
                $resultuhk->free();
                $stmtuhk->close();
              ?>
            </select></div>
          <div class="float">
      <p><button type="submit" class="fa fa-trash none c-6 b-orange" name="DeleteKategorie" value="" /></button></p>
    </div>
  </div>
  </form>

  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="Userkategorie"> User Kategorie zuweisen </label>
        <select name="ChangeUserID" class="" id="BenutzerIDlöschen"
            required="true">
            <option value="">Bitte auswählen... </option>
            <?php
              $queryuhk = "SELECT * FROM users";
              $stmtuhk = $mysqli->prepare($queryuhk);
              $booluhk = $stmtuhk->execute();
              $resultuhk = $stmtuhk->get_result();
              while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['user_ID'].'">'.$rowuhk['username'].'</option>';}
              $resultuhk->free();
              $stmtuhk->close();
            ?>
          </select>
          <select name="ChangeKatergorieID" class="" id="BenutzerIDlöschen"
              required="true">
              <option value="">Bitte auswählen... </option>
              <?php
                $queryuhk = "SELECT * FROM kategorie";
                $stmtuhk = $mysqli->prepare($queryuhk);
                $booluhk = $stmtuhk->execute();
                $resultuhk = $stmtuhk->get_result();
                while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['kategorie_ID'].'">'.$rowuhk['name'].'</option>';}
                $resultuhk->free();
                $stmtuhk->close();
              ?>
            </select>
            </div>
          <div class="float">
      <p><button type="submit" class="fa fa-comment none c-6 b-orange" name="Userkategorie" value="" /></button></p>
    </div>
  </div>
  </form>

  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="Kategorienameerstellen"> Kategorie erstellen </label>
      <input type="text" name="Kategorienameerstellen" class="form-control" id="title"
          value=""
          placeholder="geben Sie einen Namen ein!"
          title=""
          maxlength="30" required="true"/>
          </div>
          <div class="float">
      <p><button type="submit" class="fa fa-plus none c-5 b-orange" name="Kategorieerstellen" value="" /></button></p>
    </div>
  </div>
  </form>

  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="Kategorienamelöschen"> Kategorie löschen </label>
        <select name="Kategorienamelöschen" class="" id="BenutzerIDlöschen"
            required="true">
            <option value="">Bitte auswählen... </option>
            <?php
              $queryuhk = "SELECT * FROM kategorie";
              $stmtuhk = $mysqli->prepare($queryuhk);
              $booluhk = $stmtuhk->execute();
              $resultuhk = $stmtuhk->get_result();
              while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['kategorie_ID'].'">'.$rowuhk['name'].'</option>';}
              $resultuhk->free();
              $stmtuhk->close();
            ?>
          </select>
          </div>
          <div class="float">
      <p><button type="submit" class="fa fa-trash none c-5 b-orange" name="Kategorielöschen" value="" /></button></p>
    </div>
  </div>
  </form>


  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="Benutzernameerstellen"> Benutzer erstellen </label>
        <input type="text" name="Benutzernameerstellen" class="form-control" id="title"
                placeholder="Gross- und Keinbuchstaben, min 6 Zeichen."
                maxlength="30" required="true"
                pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}"
                title="Gross- und Keinbuchstaben, min 6 Zeichen."/>
          <input type="password" name="Benutzerpassword" class="form-control" id="password"
                  placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute"
                  pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
                  title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
                  required="true"/>
          </div>
          <div class="float">
      <p><button type="submit" class="fa fa-plus none c-2 b-orange" name="Benutzererstellen" value="" /></button></p>
    </div>
  </div>
  </form>


    <form action="" method="POST">
      <div class="form-group mitte">
        <div class="float null">
          <label for="BenutzerIDlöschen"> Benutzer löschen </label>
            <select name="BenutzerIDlöschen" class="" id="BenutzerIDlöschen"
                required="true">
                <option value="">Bitte auswählen... </option>
                <?php
                  $queryuhk = "SELECT * FROM users";
                  $stmtuhk = $mysqli->prepare($queryuhk);
                  $booluhk = $stmtuhk->execute();
                  $resultuhk = $stmtuhk->get_result();
                  while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['user_ID'].'">'.$rowuhk['username'].'</option>';}
                  $resultuhk->free();
                  $stmtuhk->close();
                ?>
              </select>
            </div>
            <div class="float">
        <p><button type="submit" class="fa fa-trash none c-2 b-orange" name="Benutzerlöschen" value="" /></button></p>
      </div>
    </div>
    </form>

  </div>
</div>


<script>// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}
</script>

</footer>
<?php }?>
<script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-9bf952ccbbd13c245169a0a1190323a27ce073a3d304b8c0fdf421ab22794a58.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script id="rendered-js" src="main.js"></script>
</body>
</html>
