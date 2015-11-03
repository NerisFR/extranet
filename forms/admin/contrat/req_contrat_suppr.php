<?php

    $id_contrat = $_POST['id_contrat'];

    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $req_send = "DELETE FROM contrats WHERE contrats.id = ".$id_contrat;

    $db->exec($req_send);

    echo "<br></br>";
    echo "<span>Le contrat n°".$id_contrat." a bien été supprimée!</span>";
    echo "<br></br>";


?>