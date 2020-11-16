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

// Formular wurde gesendet und Besucher ist noch nicht angemeldet.


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

			<!-- Main -->
				<section id="main">
					<!-- Banner -->
						<section id="banner">
							<!--inner Div-->
							<div class="inner">
								<h1>To-Do's aus der Zukunft</h1>
									<p>Sei immer auf dem neusten Stand um nichts zu verplanen oder zu vergessen!</p>

						<!--Anmeldungscheck mit Ausgabe des Usernames-->
						<?php	if(isset($_SESSION['e_username'])&&isset($_SESSION['registriert'])&&$_SESSION['registriert']==true){
									echo '<p>'. "Sie sind nun registriert mit dem Nutzernamen: "
											.'<i class="fa fa-user"></i>'
											." ". $_SESSION['e_username'].'</p>';
									$_SESSION['e_username'] = ''; $_SESSION['registriert']= false;}
									if(isset($_SESSION['username'])){
									echo '<p>'."&nbsp; Sie sind jetzt angemeldet !"
											."<br>".'<i class="fa fa-user"></i>'
											." ". $_SESSION['username'].'</p>';
									?><form action="" method="POST">
									  <div class="form-group mitte">
									  <input type="submit" class="button alt scrolly big" name="logoutAction" value="LOGOUT" />
									</div>
									</form>
									<div class="form-group mitte">
									<?php
									//Admincheck
									if(isset($_SESSION['Admin'])&&$_SESSION['Admin']==true){
									  echo '<a href="Admin.php" class="button alt scrolly small">'
												.'<i class="fas fa-cogs"></i>'.'</a>'.'</div>';
									}
									}
									if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logoutAction'])){
									  if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
									  $_SESSION = [];
									  $_SESSION = array();
									  session_destroy();
									  ?><script> for (i = 0; i < 1; i++){location.reload();} </script><?php
									}
									}
									?>

					</div>
				</section>

					<!-- Gallery -->
						<section id="galleries">

							<!-- Photo Galleries -->
								<div class="gallery">
									<header class="special">
										<h2>Beispiel zweier To-Do's</h2>
									</header>
									<div class="content">
										<div class="media">
											<img src="images/thumbs/1.png" alt=""  /><div class="Kasten"><h1 style="color: black;font-size:200%;margin:0px;text-align:center">Beispiel einer To-Do</h1>
												<p style="font-size:25px;">In jeder eurer Todo's könnt ihr das Datum eintragen, bis wann ihr die Todo erledigt haben müsst, einen Detailtext und Weiteres...</p>
												<span style="font-size:25px;">Zu erledigen bis: 2020-03-03<br>
												Tage Zeit: <span style="color: green;">2</span><br>
												ID der Todo: <b>0</b></span>
											</div>
										</div>
										<div class="media">
											<img src="images/thumbs/5.png" alt=""  /><div class="Kasten"><h1 style="color: black;font-size:200%;margin:0px;text-align:center">Beispiel einer To-Do</h1>
												<p style="font-size:25px;">Anhand der Farbe des Randes, kann man erkennen, wie wichtig die Todo eingeteilt wurde. Zudem werden alle Todo's erst nach Wichitigkeit und dann nach Datum sortiert.</p>
												<span style="font-size:25px;">Zu erledigen bis: 2020-03-03<br>
												Tage Zeit: <span style="color: green;">2</span><br>
												ID der Todo: <b>0</b></span>
											</div>
										</div>
									</div>
									<footer>
										<a href="Anzeige.php" class="button big">deine Todo's</a>
									</footer>
								</div>
						</section>

					<!-- Contact -->
						<section id="contact">
							<!-- Social -->
								<div class="social column">
									<h3>Über die Webseite/-applikation</h3>
									<p>Die Webseite wurde, aus einer früheren Idee heraus, neu entwickelt. Somit ist sie eine Weiterentwiklung einer bisher bestehenden To-Do Webapplikation. Die Version 1.0 ist während einem schulischen Projekt im Modul 151 entstanden, wurde anschlliessend weiterentwichelt und ist Schlussendlich nocheinmal mit neunem Disign und neuen Features als diese Version entstanden. Somit kann man die aktuelle Version, als Version 3.0 sehen.</p>
										<h3>neuste Updates</h3>
									<p>
										Version 1.0: erste Features<br>
										Version 1.1: To-Do's und User haben Katergorien zugeordnet<br>
										Version 2.1: To-Do's können bearbeitet, archiviert und gelöscht werden<br>
										Version 2.2: Admin hinzugefügt, der diverse Möglichkeiten zur verfügung hat<br>
										Version 3.0: neues Disign und neue Features<br>
										Version 3.1: Privatsphäre für To-Do's<br>
										*Version 3.2: Bearbeitung für Userdaten</p>
									<h3></h3>
								</div>

							<!-- Form -->
								<div class="column">
									<?php	if (isset($_SESSION['username'])&&$_SESSION['loggedin']==true){
										echo '<h3>'." Sie sind jetzt angemeldet!".'<br>'."Wilkommmen zurück: "."<br>".'<i class="fa fa-user"></i>'." ". $_SESSION['username'].'</h3>';
										?><form action="" method="POST">
										  <div class="form-group mitte">
										  <input style="color:black;" type="submit" class="button alt scrolly small" name="logoutAction" value="LOGOUT" />
										</div>
										</form>
									<?php }else{ ?>
									<h3>Login</h3>
										<form action="" method="POST">
									  <div class="form-group">
									  <label for="username">Benutzername *</label>
										<select name="username" class="" id="BenutzerIDlöschen"
												required="true">
												<option value="">Bitte auswählen... </option>
												<?php
													$queryuhk = "SELECT * FROM users";
													$stmtuhk = $mysqli->prepare($queryuhk);
													$booluhk = $stmtuhk->execute();
													$resultuhk = $stmtuhk->get_result();
													while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['username'].'">'.$rowuhk['username'].'</option>';}
													$resultuhk->free();
													$stmtuhk->close();
												?>
											</select>
									  </div>
									  <!-- password -->
									  <div class="form-group">
									    <label for="password">Password *</label>
									    <input type="password" name="password" class="form-control" id="password"
									        placeholder="Bitte geben Sie ihr Passwort ein!"
									        pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
									        title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
									        required="true">
									  </div><br>
									    <button type="submit" name="button" value="submit" class="btn btn-info">Login</button>
									    <button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
									</form>
									<?php include('PHP-Files/Anmeldung.php');
									include('PHP-Files/Benutzererstellen.php'); ?>

									<ul class="actions">
									<br>
										<p style="color: darkblue;"><span id="an"
										onclick="document.getElementById('text').style.display='block';document.getElementById('an').style.display='none';document.getElementById('zu').style.display='block'"
										style="cursor:pointer;">Sie haben noch keinen Account?</span>
										<span id="zu" onclick="document.getElementById('text').style.display='none';document.getElementById('an').style.display='block';document.getElementById('zu').style.display='none'"
										style="display: none;cursor: pointer;">Sie haben noch keinen Account?</span></p>
									<div id="text" style="display: none">
									<br>

									<form action="" method="post">
									  <!-- benutzername -->
									  <div class="form-group">
									    <label for="e_username">Benutzername *</label>
									    <input type="text" name="e_username" class="form-control" id="e_username"
									            placeholder="Gross- und Keinbuchstaben, min 6 Zeichen."
									            maxlength="30" required="true"
									            pattern="(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,}"
									            title="Gross- und Keinbuchstaben, min 6 Zeichen."/>
									  </div>
									  <!-- password -->
									  <div class="form-group">
									    <label for="e_password">Password *</label>
									    <input type="password" name="e_password" class="form-control" id="e_password"
									            placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute"
									            pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
									            title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
									            required="true">
									  </div>
									  <button type="submit" name="button" value="submit" class="btn btn-info">Senden</button>
									  <button type="reset" name="button" value="reset" class="btn btn-warning">Löschen</button>
									</form>
									</div>
									</ul>
									<?php } ?>
								</div>

						</section>

					<!-- Footer -->

				</section>
		</div>

		<!-- Scripts -->
		<script>
		$(document).ready(function(){
				/* Hier der jQuery-Code */
				$('#sobo-einausblenden').click(function(){
					$('#mehranzeigen').toggle('200');
				})
		});
		</script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
