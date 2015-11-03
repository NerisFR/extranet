<?php
session_start();
setlocale(LC_TIME, "fr_FR");
$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
$NDS = array();
$collabid = $_GET['collab_id'];
$clientid = $_GET['client_id'];
$contratid = $_GET['contrat_id'];
$datedeb = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['date_debut'])));
$datefin = date("Y-m-d", strtotime(str_replace('/', '-', $_GET['date_fin'])));
$typeheure = $_GET['type_heure'];
    
    if($collabid==0){
        if(($clientid==0) AND ($contratid==0)){
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (nds.type_heure='".$typeheure."') ORDER BY jour DESC;" or die (mysql_error());
        }
        elseif($contratid==0){
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (nds.type_heure='".$typeheure."') AND (clients.id='".$clientid."') ORDER BY jour DESC;" or die (mysql_error());
        }
        else{
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (contrats.id = '".$contratid."') AND (nds.type_heure='".$typeheure."') ORDER BY jour DESC;" or die (mysql_error());
        }
    }
    else{
        if(($clientid==0) AND ($contratid==0)){
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (collaborateurs.id = '".$collabid."') AND (nds.type_heure='".$typeheure."') ORDER BY jour DESC;" or die (mysql_error());
        }
        elseif($contratid==0){
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (collaborateurs.id = '".$collabid."') AND (nds.type_heure='".$typeheure."') AND (clients.id='".$clientid."') ORDER BY jour DESC;" or die (mysql_error());
        }
        else{
            $req = "SELECT nds.id as id, nds.jour as jour, clients.nom as client, nds.arrivee as arrivee, nds.depart as depart, nds.tps_total as tps_total, nds.commentaire as commentaire, nds.type_heure as type_heure, contrats.description as description, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE  ((nds.Jour) BETWEEN '".$datedeb."' AND '".$datefin."') AND (collaborateurs.id = '".$collabid."') AND (contrats.id = '".$contratid."') AND (nds.type_heure='".$typeheure."') ORDER BY jour DESC;" or die (mysql_error());
        }
    }
    $cli = $db->query($req);
    $NDS = $cli->fetchall();


header("Content-Type: text/csv; charset=UTF-8");
header("Content-Type: text/csv");
header("Content-disposition: filename=mon-tableau.csv");
// Création de la ligne d'en-tête
$entete = array("id", "Date", "Client", "Contrat", "Arrivée", "Départ", "Temps", "Commentaire");

// Création du contenu du tableau
$lignes = array();
foreach ($NDS as $row) {
$lignes[] = array($row[0], $row[1], $row[2], $row[8], $row[3], $row[4], $row[5], $row[6]);
  };
$separateur = ";";

// Affichage de la ligne de titre, terminée par un retour chariot
echo implode($separateur, $entete)."\r\n";

// Affichage du contenu du tableau
foreach ($lignes as $ligne) {
	echo implode($separateur, $ligne)."\r\n";
}