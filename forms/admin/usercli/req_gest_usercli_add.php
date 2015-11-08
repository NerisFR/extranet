<?php

    include '../../functions.php';
    $nom_usercli = $_POST['nom_usercli'];
    $prenom_usercli = $_POST['prenom_usercli'];
    $fonction_usercli = $_POST['fonction_usercli'];
    $loggin_usercli = $_POST['loggin_usercli'];
    $password_usercli = md5($_POST['password_usercli']);
    $id_client = $_POST['myid'];
    global $db;
    $rep = $db->query("INSERT INTO user_client(id, nom, prenom, fonction, loggin, password, id_client) VALUES ('','$nom_usercli','$prenom_usercli','$fonction_usercli','$loggin_usercli','$password_usercli','$id_client')");
    
    $rep->closeCursor();

    echo "<div>";
    echo "<span>La nouvelle affectation a bien été enregistré.</span>";
    echo "</div>";

?>
  