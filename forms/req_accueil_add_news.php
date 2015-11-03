<?php

	include 'functions.php';
	setlocale(LC_TIME, "fr_FR.utf8");
    $commentaire = htmlentities($_POST['comment'], ENT_QUOTES, "UTF-8");
    $id_collab = $_POST['myid'];
    $date = date("Y-m-d H:i:s");
    global $db;

	$rep = $db->query("INSERT INTO news(id, date, commentaire, id_collab) VALUES ('','$date','$commentaire','$id_collab')");
    
    $rep->closeCursor();

?>