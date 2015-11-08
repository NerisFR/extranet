<?php

    include '../../functions.php';
    $id_usercli = $_POST['usercli_id'];
    
    global $db;
    $rep = $db->query("DELETE FROM user_client WHERE usercli_client.id = ".$id_usercli);
    $rep->closeCursor();

    echo "<div>";
    echo "<span>L'utilisateur n°".$id_usercli." a bien été supprimé.</span>";
    echo "</div>";

?>
  