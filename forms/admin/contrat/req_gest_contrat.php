<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include '../../functions.php';
    global $db;
    $status = $_POST['status'];
    if($status == 'resilie'){
        $req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom FROM clients INNER JOIN contrats ON clients.id = contrats.id_client WHERE (contrats.date_fin_mission>'".date('Y-m-d')."')" or die (mysql_error());
        $cond = "AND ((contrats.date_fin_mission>'".date('Y-m-d')."'))";
    }
    elseif($status == 'encours'){
        $req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom FROM clients INNER JOIN contrats ON clients.id = contrats.id_client WHERE (contrats.date_fin_mission>'".date('Y-m-d')."') OR (contrats.date_fin_mission IS NULL)" or die (mysql_error());
        $cond = "AND ((contrats.date_fin_mission>'".date('Y-m-d')."') OR (contrats.date_fin_mission IS NULL))";
    }
    else{
        $req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom FROM clients INNER JOIN contrats ON clients.id = contrats.id_client" or die (mysql_error());
        $cond = "";
    }

    

    if(!empty($_POST['id_departement'])){
	$id_departement = $_POST['id_departement'];
	// $req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom FROM clients INNER JOIN contrats ON clients.id = contrats.id_client" or die (mysql_error());
	$req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom, departement.id FROM region INNER JOIN (departement INNER JOIN (clients INNER JOIN contrats ON clients.id = contrats.id_client) ON departement.id = clients.id_dep) ON region.id = departement.id_region WHERE (((departement.id)='$id_departement')) ".$cond or die (mysql_error());
    }
    if(!empty($_POST['id_client'])){
	$id_client = $_POST['id_client'];
	$req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom, departement.id FROM region INNER JOIN (departement INNER JOIN (clients INNER JOIN contrats ON clients.id = contrats.id_client) ON departement.id = clients.id_dep) ON region.id = departement.id_region WHERE (((clients.id)='$id_client')) ".$cond or die (mysql_error());
    }
    if(!empty($_POST['id_region'])){
	$id_region = $_POST['id_region'];
	$req = "SELECT contrats.id, contrats.numero, contrats.demarrage, contrats.description, clients.nom, departement.id FROM region INNER JOIN (departement INNER JOIN (clients INNER JOIN contrats ON clients.id = contrats.id_client) ON departement.id = clients.id_dep) ON region.id = departement.id_region WHERE (((region.id)='$id_region')) ".$cond or die (mysql_error());
    }



    $list_contrats = $db->query($req);
    $contrats = $list_contrats->fetchall();
    $list_contrats->closeCursor();
?>
   
    <div class='row'>
        <div class='col-xs-12'>
            <div class='box'>
                <div class='box-header'>
                    <h3 class='box-title'>Liste des clients</h3>
                </div>
                <div class='box-body'>
                    <table id='listCONT' class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Client</th>
                                <th>Description</th>
                                <th>Démarrage</th>
                                <th style="opacity:0">&nbsp;</th>
                                <th style="opacity:0">&nbsp;</th>
                                <th style="opacity:0">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($contrats as $contrat) {
                                    echo "<tr>";
                                    echo "<td>".$contrat[1]."</td>";
                                    echo "<td>".$contrat[4]."</td>";
                                    echo "<td>".$contrat[3]."</td>";
                                    echo "<td>".date("d/m/Y", strtotime($contrat[2]))."</td>";
                                    echo "<td><i id='$contrat[0]' style='cursor:Pointer' class='ion-compose edit-cont'></i></td>";
                                    echo "<td><i id='$contrat[0]' style='cursor:Pointer' class='ion-search view-cont'></i></td>";
                                    echo "<td><i id='$contrat[0]' style='cursor:Pointer' class='ion-close del-cont'></i></td>";
                                    echo "</tr>";
                                      
                                };
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


<script type='text/javascript'>
      $(function () {
          secure_contrat();
        $('#listCONT').DataTable({
            'language': {
                "lengthMenu": "_MENU_ enregistrements par page",
                "zeroRecords": "Aucun résultat - Désolé",
                "info": "page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement",
                "infoFiltered": "(filtrage sur un total de _MAX_ enregistrement)",
                "search": "Recherche"
            },
            'dom': '<"row"<"col-xs-4"l><"col-xs-4"f><"col-xs-4"T>><t>ip',
            'tableTools': {
                "sSwfPath": "./plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [

                    {
                        "sExtends":    "collection",
                        "sButtonText": "Enregistrer",
                        "aButtons":    [ "csv", "xls", "pdf" ]
                    }
                ]
            },
            
            'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': false

        });
      });
</script>