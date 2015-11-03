<?php

    //include 'extranet/forms/functions.php';
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    //global $db;
    $data = array();
    $collabid = mysql_real_escape_string($_POST['collab_id']);
    //$collabid = htmlentities(intval($_POST['collab_id']));
    //$collabid=3;
    $req = "SELECT DISTINCT clients.id, clients.nom FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)='$collabid'))" or die (mysql_error());
    $cli = $db->query($req);
    //$clients = $cli->fetchall();
    //foreach($clients as $row){
    while($donnees = $cli->fetch(PDO::FETCH_OBJ)) {
        $currentid = "$donnees->id";
        $currentvalue = "$donnees->nom";
        $data[] =     array('index'=>$currentid,'value'=>$currentvalue);
      //$json[$donnees["id"]][] = utf8_encode($donnees["nom"]);
        //echo $row[1];
        //echo " ";
            };

  echo json_encode($data);
?>