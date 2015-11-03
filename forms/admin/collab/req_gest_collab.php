<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    include '../../functions.php';
    global $db;
// $id_departement = mysql_real_escape_string($_POST['id_departement']);
//$id_region = mysql_real_escape_string($_POST['id_region']);

// if ($id_departement<>0){
		
//		$req = ;
		$list_collab = $db->query("SELECT collaborateurs.id, collaborateurs.nom, collaborateurs.prenom, collaborateurs.fonction, collaborateurs.embauche, collaborateurs.debauche, collaborateurs.id_profils, profils.profils
FROM profils INNER JOIN collaborateurs ON profils.id = collaborateurs.id_profils");
		$collabs = $list_collab->fetchall();
                $list_collab->closeCursor();
	// }
	// else{
	// 	$db = new PDO('mysql:host=localhost;dbname=extranet;charset=utf8', 'root', 'Scirpaceus17');
	// 	$req = "SELECT clients.nom, clients.adresse, clients.cp, clients.ville, clients.id FROM clients" or die (mysql_error());
	// 	$list_clients = $db->query($req);
	// 	$clients = $list_clients->fetchall();
	// };

    echo "<div class='row'>";
    echo "<div class='col-xs-12'>";
    echo "<div class='box'>";
    echo "<div class='box-header'>";
    echo "<h3 class='box-title'>Liste des collaborateurs</h3>";
    echo "</div>";
    echo "<div class='box-body'>";
    echo "<table id='listCOLLAB' class='table table-bordered table-striped table-hover display nowrap'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nom</th>";
    echo "<th>Prenom</th>";
    echo "<th>Fonction</th>";
    echo "<th>Embauche</th>";
    echo "<th>Debauche</th>";
    echo "<th>Profil</th>";
    echo "<th>&nbsp;</th>";
    echo "<th>&nbsp;</th>";
    echo "<th>&nbsp;</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    
	
    foreach ($collabs as $collab) {
	echo "<tr>";
        echo "<td>".$collab[1]."</td>";
        echo "<td>".$collab[2]."</td>";
        echo "<td>".$collab[3]."</td>";
        if($collab[4]){
           echo "<td>".date("d/m/Y", strtotime($collab[4]))."</td>"; 
        }
        else{
            echo "<td>&nbsp;</td>";
        }
        if($collab[5]){
           echo "<td>".date("d/m/Y", strtotime($collab[5]))."</td>"; 
        }
        else{
            echo "<td>&nbsp;</td>";
        }
        echo "<td>".$collab[7]."</td>";
        echo "<td><i id='$collab[0]' style='cursor:Pointer' class='ion-compose edit-collab'></i></td>";
        echo "<td><i id='$collab[0]' style='cursor:Pointer' class='ion-search view-collab'></i></td>";
        echo "<td><i id='$collab[0]' style='cursor:Pointer' class='ion-close del-collab'></i></td>";
        echo "</tr>";
    };

echo "</tbody>";
echo "</table>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";

?>

<script type='text/javascript'>
      $(function () {
          secure_collab();
//        $('#example1').DataTable();
        $('#listCOLLAB').DataTable({
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