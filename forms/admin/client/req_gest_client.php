<?php

/*$id_departement = $_POST['id_departement'];
$id_region = $_POST['id_region'];*/
error_reporting(E_ALL);
ini_set("display_errors", 1);
include '../../functions.php';
global $db;
    
/*if ($id_departement!=0){
		$list_clients = $db->query("SELECT clients.nom, clients.adresse, clients.cp, clients.ville, clients.id FROM clients WHERE clients.id_dep = ".$id_departement);
		$clients = $list_clients->fetchall();
	}
	else if($id_departement!=0){
		$list_clients = $db->query("SELECT clients.nom, clients.adresse, clients.cp, clients.ville, clients.id FROM region INNER JOIN (departement INNER JOIN clients ON departement.id = clients.id_dep) ON region.id = departement.id_region WHERE (((region.id)=".$id_region."))");
		$clients = $list_clients->fetchall();
	}else{*/
    $list_clients = $db->query("SELECT clients.nom, clients.adresse, clients.cp, clients.ville, clients.id FROM clients");
    $clients = $list_clients->fetchall();
/*  };*/
        $list_clients->closeCursor();
?>
    <div class='row'>
    <div class='col-xs-12'>
    <div class='box'>
    <div class='box-header'>
    <h3 class='box-title'>Liste des clients</h3>
    </div>
    <div class='box-body'>
    <table id='listCLI' class='table table-bordered table-striped table-hover display nowrap' cellspacing="0" width="100%">
    <thead>
    <tr>
    <th>Nom</th>
    <th>Adresse</th>
    <th>CP</th>
    <th>Ville</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
        
<?php
foreach ($clients as $client) {
    echo "<tr>";
    echo "<td>".$client[0]."</td>";
    echo "<td>".$client[1]."</td>";
    echo "<td>".$client[2]."</td>";
    echo "<td>".$client[3]."</td>";
    echo "<td><i id='$client[4]' style='cursor:Pointer' class='ion-compose edit-cli'></i></td>";
    echo "<td><i id='$client[4]' style='cursor:Pointer' class='ion-search view-cli'></i></td>";
    echo "<td><i id='$client[4]' style='cursor:Pointer' class='ion-close del-cli'></i></td>";
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
        secure_client()
        $('#listCLI').DataTable({
            language: {
                lengthMenu: "_MENU_ résutats par page",
                zeroRecords: "Aucun résultat - Désolé",
                info: "page _PAGE_ sur _PAGES_",
                infoEmpty: "Aucun enregistrement",
                infoFiltered: "(filtrage sur un total de _MAX_ enregistrement)",
                search: "Recherche"
            },
            responsive: {
                details: {
                    renderer: function ( api, rowIdx ) {
                    // Select hidden columns for the given row
                    var data = api.cells( rowIdx, ':hidden' ).eq(0).map( function ( cell ) {
                        var header = $( api.column( cell.column ).header() );
 
                        return '<tr>'+
                                '<td>'+
                                    header.text()+':'+
                                '</td> '+
                                '<td>'+
                                    api.cell( cell ).data()+
                                '</td>'+
                            '</tr>';
                    } ).toArray().join('');
 
                    return data ?
                        $('<table/>').append( data ) :
                        false;
                    }
                }
            },
            dom: '<"row"<"col-xs-4"l><"col-xs-4"f><"col-xs-4"<"pull-right"T>>><t>ip',
            /*'dom': 'TBfrtip',*/
            tableTools: {
                sSwfPath: "./plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                   /* "copy",
                    "print",*/
                    {
                        sExtends:    "collection",
                        sButtonText: "Enregistrer",
                        aButtons:    [ "csv", "xls", "pdf" ]
                    }
                ]
            },
            
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true
            
        });
      });
</script>