<?php
    include '../../functions.php';
    $civ = $_POST['civ'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $fonction = $_POST['fonction'];
    $arrivee=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['arrivee'])));
    $depart = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['depart'])));
    $loggin = $_POST['loggin'];
    $passwd = $_POST['passwd'];
    $admin = $_POST['admin'];
    $nom_usage = $prenom." ".$nom;
    $id_profil = $_POST['id_profil'];
    global $db;
    
//    $req_send = "INSERT INTO collaborateurs(id, civilite, nom, prenom, fonction, embauche, debauche, nom_usage, login, password, admin) VALUES ('','$civ','$nom','$prenom','$fonction','$arrivee','$depart','$nom_usage','$loggin','$passwd','$admin')";
    $rep = $db->query("INSERT INTO collaborateurs(id, civilite, nom, prenom, fonction, embauche, debauche, nom_usage, login, password, id_profils) VALUES ('','$civ','$nom','$prenom','$fonction','$arrivee','$depart','$nom_usage','$loggin','$passwd','$id_profil')");
    $rep->closeCursor();

    echo "<div>";
    echo "<span>Le nouveau collaborateur a bien été enregistré.</span>";
    echo "</div>";


?>
  