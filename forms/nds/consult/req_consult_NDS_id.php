<?php
	$nds_id = $_POST['nds_id'];
	// var_dump($nds_id);
	


	$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
	$req = "SELECT nds.id as id, nds.jour as jour, clients.id as client_id, contrats.id as contrat_id, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure,  collaborateurs.id as collab_id, nds.tps_adm , nds.tps_maint, nds.tps_parc, nds.tps_prix, nds.tps_inst, nds.tps_assist, nds.tps_form, nds.tps_proj, nds.tps_dev, nds.tps_reunion, nds.tps_dep, nds.tps_ctrl, nds.tps_autre, nds.ctrl_log, nds.ctrl_hdd, nds.ctrl_raid, nds.ctrl_maj_os, nds.ctrl_maj_hard, nds.ctrl_maj_soft, nds.ctrl_backup, nds.volum_backup, nds.maj_backup, nds.ctrl_antivirus, nds.maj_antivirus FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  nds.id = '".$nds_id."'" or die (mysql_error());
	$list_nds = $db->query($req);
	$nds = $list_nds->fetch(PDO::FETCH_ASSOC);
	$dbConnect = null;


	echo json_encode($nds);

?>