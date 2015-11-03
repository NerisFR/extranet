<?php

    include '../../functions.php';
    $id_cli = $_POST['client_id'];
    
    global $db;
    $rep = $db->query("DELETE FROM clients WHERE clients.id = ".$id_cli);
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le client n°".$id_cli." a bien été supprimé.</span>";
    echo "</div>";

?>
  