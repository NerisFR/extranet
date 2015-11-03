<?php

    include '../../functions.php';
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
    
    global $db;
    $rep = $db->query("INSERT INTO clients(id, nom, cp, adresse, ville, id_dep, SIRET, tel, web, mail, fax) VALUES ('','$nom_client','$cp_client','$adresse_client','$ville_client','$dep_client','$SIRET_client','$tel_client','$web_client','$mail_client','$fax_client')");
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le nouveau client a bien été enregistré.</span>";
    echo "</div>";

?>
  