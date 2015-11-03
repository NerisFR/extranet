<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    include '../../functions.php';
    global $db;
    $nds_id = $_POST['nds_id'];

    $req_send = "DELETE FROM nds WHERE nds.id = ".$nds_id;
    $rep = $db->exec($req_send);
    $rep->closeCursor();
    echo "<br></br>";
    echo "<span>La note de synthèse n°".$nds_id." a bien été supprimée!</span>";
    echo "<br></br>";


?>
  