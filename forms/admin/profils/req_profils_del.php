<?php

    include '../../functions.php';
    $id_profil = $_POST['profil_id'];
    
    global $db;
    $rep = $db->query("DELETE FROM profils WHERE profils.id = ".$id_profil);
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le profil n°".$id_profil." a bien été supprimé.</span>";
    echo "</div>";

?>
  