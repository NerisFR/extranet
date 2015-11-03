<?php
	    include '../../functions.php';
	$num = $_POST['num'];
	$date_sign = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_sign'])));
	$duree = $_POST['duree'];
	$date_dem = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_dem'])));
	$preavis = $_POST['preavis'];
	$marche = $_POST['marche'];
	$tacite = $_POST['tacite'];
	$id_cli = $_POST['id_cli'];
	$base_sem = $_POST['base_sem'];
	$nb_mois = $_POST['nb_mois'];
	$desc = $_POST['desc'];
	$id_contrat = $_POST['id_contrat'];
	$date_fin_mission = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date_fin_mission'])));
	global $db;
	
 	$req_send = "INSERT INTO contrats(id, numero, signature, volume, demarrage, date_fin_mission, marche, reconduction, base_sem, nb_mois, description, id_client) VALUES ('','$num','$date_sign','$vol','$date_dem', '$date_fin_mission', $marche','$tacite','$base_sem','$nb_mois','$desc','$id_cli')";
    $db->query($req_send);
    $rep->closeCursor();

    echo "<br></br>";
    echo "<span>Le contrat n°$num a bien été enregistré.</span>";
    echo "<br></br>";




?>