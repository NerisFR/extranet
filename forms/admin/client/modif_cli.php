<!--INSERT ID_DEP-->

<?php
	$nom_client = $_POST['nom_client'];
	$cp_client = $_POST['cp_client'];
	$adresse_client= $_POST['adresse_client'];
	$ville_client= $_POST['ville_client'];
	$SIRET_client= $_POST['SIRET_client'];
	$dep_client= $_POST['dep_client'];
	$tel_client= $_POST['tel_client'];
	$web_client= $_POST['web_client'];
	$mail_client= $_POST['mail_client'];
	$fax_client= $_POST['fax_client'];
	$id_client= $_POST['id_client'];



	$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
	$req_send = "UPDATE clients SET nom='$nom_client', cp = '$cp_client', adresse = '$adresse_client', ville = '$ville_client', SIRET = '$SIRET_client', tel = '$tel_client', web = '$web_client', mail = '$mail_client', fax = '$fax_client' WHERE clients.id = $id_client";
    $db->exec($req_send);

    echo "<br></br>";
    echo "<span>Le client $nom_client a bien été modifié.</span>";
    echo "<br></br>";




?>