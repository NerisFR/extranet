<?php
// liste des événements
 $json = array();
 // requête qui récupère les événements
 // $requete = "SELECT planning.id, start, end, clients.nom as title, id_client FROM planning INNER JOIN clients ON planning.id_client=clients.id ORDER BY planning.id";
 $requete = "SELECT planning.id, planning.start, planning.end, clients.nom as title, colors.ref as backgroundColor
			FROM (colors INNER JOIN (collaborateurs INNER JOIN (clients INNER JOIN color_client_collab ON clients.id = color_client_collab.id_client) ON collaborateurs.id = color_client_collab.id_collab) ON colors.id = color_client_collab.id_color) INNER JOIN planning ON (collaborateurs.id = planning.id_collab) AND (clients.id = planning.id_client)
			WHERE (((collaborateurs.id)=1))";

 // connexion à la base de données
 include '../../functions.php';
 global $db;
 // exécution de la requête
 $resultat = $db->query($requete) or die(print_r($bdd->errorInfo()));
 
 // envoi du résultat au success
 echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));
 
?>