<!DOCTYPE HTML>
<?php session_start(); session_regenerate_id();
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
		<title>Gallery - Snapshot by TEMPLATED</title>
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
						<li><a href="index.php"><span class="icon fa-home"></span></a></li>
						<li><a href="index.php#contact"><i class="fas fa-users"></i></a></li>
						<li><a href="Anzeige.php" class="active"><i class="fas fa-file-alt"></i></a></li>
						<li><a href="Anzeige.php#contact"><i class="fas fa-file-upload"></i></a></li>
						<br><br>
						<li><a href="https://twitter.com/Mada_DV" target="_blank" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
					</ul>
				</nav>

			<!-- Main -->
				<section id="main">

					<!-- Gallery -->
						<section id="galleries">

							<!-- Photo Galleries -->
								<div class="gallery">

									<!-- Filters -->
										<header style="position: fixed; z-index: 2;">
											<h1 style="padding-right: 5px;">Todo's: </h1>
											<ul class="tabs">
												<li><a href="#" data-tag="all" class="button active">All</a></li>
												<li><a href="#" data-tag="5" class="button">5</a></li>
												<li><a href="#" data-tag="4" class="button">4</a></li>
												<li><a href="#" data-tag="3" class="button">3</a></li>
												<li><a href="#" data-tag="2" class="button">2</a></li>
												<li><a href="#" data-tag="1" class="button">1</a></li>
												<li><button id="myBtn"><i style="color: black;" class="fas fa-edit"></i> Edit </button></li>
											</ul>
										</header>

	<div style="margin-top: 10%;" class="content">
										<?php
										if (isset($_SESSION['username'])&&$_SESSION['loggedin']==true){
											// maximale anzahl zeile ermitteln
							        $sql = "SELECT todo_ID FROM todo";
							        if($result = $mysqli->query($sql)){
							        	$rowCount = $result->num_rows;
							        } else {
							        	printf("Query failed: %s\n", $mysqli->connect_error);
							        	exit();
							        }

							        //anzahl Zeilen welche pro Seite ausgegeben werden
							        $count = 100;

							        // zurück geklickt
							        if(isset($_GET['last'])){
							        	// wenn seite zurück kleiner als 0 > Anfang
							        	if($_GET['last'] < 0){
							        		$start = 0;
							        		$last = 0;
							        		$next = $count;
							        	} else {
							        		$start = $_GET['last'];
							        		$last = $start - $count;
							        		$next = $start + $count;
							        	}
							        // vorwärts geklickt
							        } elseif(isset($_GET['next'])){
							        	// wenn seite vor grösser max. Anzahl zeilen in Tabelle > letzte seite
							        	if($_GET['next'] > $rowCount){
							        		$start = $_GET['next'] - $count;
							        		$last = $start - $count;
							        		$next = $start + $count;
							        	} else {
							        		$start = $_GET['next'];
							        		$last = $start - $count;
							        		$next = $start + $count;
							        	}
							        // initialisierung
							        } else {
							        	$start = 0;
							        	$last = 0;
							        	$next = $count;

							        }

										    //    select Statement mit LIMIT
										   include('PHP-Files/TodosAnzeige.php');

										 ?>
								</div>
								</div>
						</section>

					<!-- Contact -->
						<section id="contact">
							<!-- Social -->

							<!-- Form -->
								<div class="column">
									<h3>neue Todo erstellen:</h3>
		<form action="" method="POST">
    <div class="form-group">
    <label for="title">Titel:</label>
    <input type="text" name="title" class="form-control" id="title"
        value=""
        placeholder="geben Sie einen Titel ein!"
        maxlength="30" required="true"
        title="Gross- und Keinbuchstaben, min 1 Zeichen.">
    </div>
    <div class="form-group">
    <label for="text">Text:</label>
    <textarea type="text" name="text" class="form-control" id="text" rows="4" cols="50"
        value=""
        placeholder="geben Sie einen Text ein!"></textarea>
    </div>
    <!-- Kategorie -->
    <div class="form-group">
      <label for="deadline">Kategorie:</label>
      <select name="kategorie" class="" id="kategorie"
          required="true">
        <?php include('PHP-Files/KategorienAbfrage.php'); ?>

        </select>
    </div>
    <!--Deadline -->
    <script>
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      startDate: '-3d'
     });
    </script>
    <div class="form-group">
      <label for="deadline">Deadline</label>
      <input type="date" name="deadline" class="" data-date-format="mm/dd/yyyy" id="deadline"
          required="true">
    </div>
    <div class="form-group">
      <label for="priority">Priority: </label>
      <select name="priority" class="" id="kategorie"
          required="true">
          <option value=1>1</option>
           <option value=2>2</option>
            <option value=3>3</option>
             <option value=4>4</option>
              <option value=5>5</option>
        </select>
    </div><br>
      <button type="submit" name="Submit" value="submit" class="btn btn-info">Submit</button>

  </form>
	<?php
include('PHP-Files/TodoErstellen.php');
}else{?>
	<h1 style="text-align:center;">Um eine Todo zu schreiben müssen Sie sich mit einem Account anmelden </h1>

	<?php } ?>

								</div>
								<div class="column">
					<h3> Archive </h3>
									<table style="width:100%">
										<tr>
								      <th>Inhalt</th>
								      <th>Kategorie</th>
								    </tr>
<?php
if(isset($_SESSION['usernameID'])){
if($_SESSION['usernameID']==7){
$queryarchive = "SELECT * FROM todo WHERE isArchived=1 ORDER BY priority DESC";
$stmtarchive = $mysqli->prepare($queryarchive);
$bool = $stmtarchive->execute();
$resultarchive = $stmtarchive->get_result();
while($rowarchive = $resultarchive->fetch_assoc()){if($rowarchive['title']){echo
	'<tr>'.
		'<td>'.$rowarchive['title'].'</td>'.
		'<td>'.$rowarchive['kategorie'].'</td>'.
	'</tr>'
	                                      ;}}
$resultarchive->free();
$stmtarchive->close();
}else{
	$queryarchive = "SELECT * FROM todo WHERE user_ID = ? AND isArchived=1 ORDER BY priority DESC";
	$stmtarchive = $mysqli->prepare($queryarchive);
	$stmtarchive->bind_param("i",$_SESSION['usernameID']);
	$bool = $stmtarchive->execute();
	$resultarchive = $stmtarchive->get_result();
	while($rowarchive = $resultarchive->fetch_assoc()){if($rowarchive['title']){echo
		'<tr>'.
			'<td>'.$rowarchive['title'].'</td>'.
			'<td>'.$rowarchive['kategorie'].'</td>'.
		'</tr>'
		                                      ;}}
	$resultarchive->free();
	$stmtarchive->close();
}
}

?>

 </table>
 <form action="" method="POST">
	 <div class="form-group mitte">
		 <div class="float null">
			 <label for="Archiveredoid"> Archivierung aufheben </label>
			 <select name="Archiveredoid" class="" id="BenutzerIDlöschen"
					 required="true">
					 <option value="">Bitte auswählen... </option>
					 <?php
					 if($_SESSION['usernameID']==7){
						$queryuhk = "SELECT * FROM todo WHERE isArchived = 1";
						$stmtuhk = $mysqli->prepare($queryuhk);
						$booluhk = $stmtuhk->execute();
						$resultuhk = $stmtuhk->get_result();
						while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
						$resultuhk->free();
						$stmtuhk->close();
					}else{
						$queryuhk = "SELECT * FROM todo Where isArchived = 1 AND user_ID = ?";
						$stmtuhk = $mysqli->prepare($queryuhk);
						$stmtuhk ->bind_param("i", $_SESSION['usernameID']);
						$booluhk = $stmtuhk->execute();
						$resultuhk = $stmtuhk->get_result();
						while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
						$resultuhk->free();
						$stmtuhk->close();
					}
					 ?>
				 </select>
				 </div>
				 <div class="float">
		 <p><button type="submit" class="fa fa-redo none c-5 b-orange" name="ArchiveRedo" value="" /></button></p>
	 </div>
 </div>
 </form>

								</div>

							</div>

						</section>


				</section>
		</div>




		<!-- The Modal -->
		<div id="myModal" class="modal">

		  <!-- Modal content -->
		  <div class="modal-content">
				<div id="archive">
		    <span class="close">&times;</span>
				<form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="funktionArchivieren"> Todo Archivieren: </label>
				<select name="titleArchive" class="" id="BenutzerIDlöschen"
						required="true">
						<option value="">Bitte auswählen... </option>
						<?php
						if($_SESSION['usernameID']==7){
							$queryuhk = "SELECT * FROM todo WHERE isArchived = 0";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();
						}else{
							$queryuhk = "SELECT * FROM todo Where user_ID = ? AND isArchived = 0";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$stmtuhk ->bind_param("i", $_SESSION['usernameID']);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();

							include("PHP-Files/TodosLöschenArchivieren.php");
						}
						?>
					</select>
          <div class="float">
      <p><button type="submit" class="fa fa-archive none c-4 b-yellow" name="funktionArchivieren" value="" /></button></p>
    </div>
  </div>
  </form>

  <form action="" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="funktionLöschen"> Todo Löschen: </label>
				<select name="titleLöschen" class="" id="BenutzerIDlöschen"
						required="true">
						<option value="">Bitte auswählen... </option>
						<?php
						if($_SESSION['usernameID']==7){
							$queryuhk = "SELECT * FROM todo";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();
						}else{
							$queryuhk = "SELECT * FROM todo Where user_ID = ?";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$stmtuhk ->bind_param("i", $_SESSION['usernameID']);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();
						}
						?>
					</select></div>
          <div class="float">
      <p><button type="submit" class="fa fa-trash none c-5 b-yellow" name="funktionLöschen" value="" /></button></p>
    </div>
    <div>
      <p><?php echo $error ?></p>
    </div>
  </div>
  </form>

  <form action="PHP-Files/Update.php" method="POST">
    <div class="form-group mitte">
      <div class="float null">
        <label for="funktionBearbeiten"> Todo Bearbeiten: </label>
				<select name="titleBearbeiten" class="" id="BenutzerIDlöschen"
						required="true">
						<option value="">Bitte auswählen... </option>
						<?php
						if($_SESSION['usernameID']==7){
							$queryuhk = "SELECT * FROM todo";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();
						}else{
							$queryuhk = "SELECT * FROM todo Where user_ID = ?";
							$stmtuhk = $mysqli->prepare($queryuhk);
							$stmtuhk ->bind_param("i", $_SESSION['usernameID']);
							$booluhk = $stmtuhk->execute();
							$resultuhk = $stmtuhk->get_result();
							while($rowuhk = $resultuhk->fetch_assoc()){echo '<option value="'.$rowuhk['todo_ID'].'">'.$rowuhk['title'].'</option>';}
							$resultuhk->free();
							$stmtuhk->close();
						}
						?>
					</select></div>
          <div class="float">
      <p><button type="submit" class="fa fa-edit none c-4 b-yellow" name="funktionBearbeiten" value="" /></button></p>
    </div>
  </div>
  </form>




		  </div>
		</div>
	</div>
</div>

<?php include('PHP-Files/TodosLöschenArchivieren.php'); ?>
		<!-- Scripts -->
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
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.poptrox.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
