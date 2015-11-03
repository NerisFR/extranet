<?php
    session_start();
    setlocale(LC_TIME, "fr_FR");
    try {
    $db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  catch(PDOException $e)
    {
    echo $e->getMessage();
    }
    $NDS = array();
    $myid = $_SESSION['auth']['myid'];
    $mynds = $_SESSION['auth']['nds'];
    if ($mynds=="r"){
        $req = "SELECT nds.jour as jour, clients.nom as client, contrats.description as description, nds.tps_total as tps_total, nds.commentaire as commentaire, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client ORDER BY jour DESC LIMIT 10;" or die (mysql_error());
    }
    else{
        $req = "SELECT nds.jour as jour, clients.nom as client, contrats.description as description, nds.tps_total as tps_total, nds.commentaire as commentaire, collaborateurs.id, collaborateurs.nom_usage FROM clients INNER JOIN (contrats INNER JOIN (collaborateurs INNER JOIN (affect_cont_collab INNER JOIN nds ON affect_cont_collab.id = nds.id_affect) ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat) ON clients.id = contrats.id_client WHERE collaborateurs.id = '".$myid."' ORDER BY jour DESC LIMIT 10;" or die (mysql_error());
    }
    $cli = $db->query($req);
?>
    <div class='box'>
        <div class='box-body'>
        <table class='table table-bordered table-striped table-hover display nowrap' cellspacing="0">
          <tr>
            <th class='col-lg-1'>Date</th>
            <?php
                if ($mynds=="r"){
                    echo "<th class='col-lg-2'>Collaborateur</th>";
                }
            ?>
            <th class='col-lg-2'>Client</th>
            <th class='col-lg-3'>Contrat</th>
            <th class='col-lg-1'>Heures</th>
            <th class='col-lg-3'>Comment.</th>
          </tr>
<?php
    $NDS = $cli->fetchall();

    foreach ($NDS as $row) {
        //echo $row[0];
        echo "<tr>";
        echo "<td class='col-lg-1'>".date("d/m/Y", strtotime($row[0]))."</td>";
        if ($mynds=="r"){
            echo "<td class='col-lg-2'>".$row[6]."</td>";
        }
        echo "<td class='col-lg-2'>".$row[1]."</td>";
        echo "<td class='col-lg-3' style='white-space: nowrap; overflow:hidden; text-overflow:ellipsis;max-width: 100px'>".$row[2]."</td>";
        echo "<td class='col-lg-1'>".$row[3]."</td>";
        echo "<td class='col-lg-3' style='white-space: nowrap; overflow:hidden; text-overflow:ellipsis;max-width: 150px'>".$row[4]."</td>";
        echo '</tr>';
    };
?>
</table>
</div>
</div>





  