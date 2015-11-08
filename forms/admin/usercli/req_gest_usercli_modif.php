<!--INSERT ID_DEP-->

<?php
    include '../../functions.php';
    if (!empty($_POST['date_fin'])){
        $date_fin = date("Y-m-d", strtotime(str_replace('/', '-',$_POST['date_fin'])));
        $affect_id = $_POST['affect_id'];
        global $db;
        $req_send = "UPDATE affect_cont_collab SET fin='$date_fin' WHERE affect_cont_collab.id = $affect_id";
        $rep = $db->query($req_send);
        $rep->closeCursor();
        echo "<br></br>";
        echo "<span>L'affectation a bien été modifié.</span>";
        echo "<br></br>";
    }
    else{
        echo "<br></br>";
        echo "<span>ANNULATION - Vous n'avez rien modifié.</span>";
        echo "<br></br>";
    }
    
    




?>