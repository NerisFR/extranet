<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $id_collab = $_POST['id_collab'];
    include '../../functions.php';
    global $db;

        $list_contrat = $db->query("SELECT affect_cont_collab.id, contrats.numero, contrats.description, clients.nom, affect_cont_collab.debut, affect_cont_collab.fin, collaborateurs.id, collaborateurs.nom_usage FROM (clients INNER JOIN contrats ON clients.id = contrats.id_client) INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((collaborateurs.id)=".$id_collab."))");
        $contrats = $list_contrat->fetchall();
        $list_contrat->closeCursor();

?>


    <div class='row'>
    <div class='col-xs-12'>
    <div class='box'>
    <div class='box-header'>
    <h3 class='box-title'>Liste des affectations par collaborateur</h3>
    </div>
    <div class='box-body'>
    <table id='list_affect' class='table table-bordered table-striped table-hover display nowrap'>
    <thead>
    <tr>
    <th>Client</th>
    <th>Contrat</th>
    <th>Début d'affectation</th>
    <th>Fin d'affectation</th>
    <th>&nbsp;</th>
    <th style="text-align:center"><font size='4pt'><i id='add-affect' onclick='add_line()' style='cursor:pointer;color:#3c8dbc' class='glyphicon glyphicon-plus-sign'></i></font></th>
    </tr>
    </thead>
    <tbody>
    
    
<?php
    foreach ($contrats as $cont) {
        if($cont[5]){
            $date_fin = date("d/m/Y", strtotime(str_replace('/', '-', $cont[5])));
        }
        else{
            $date_fin = "";
        }
        $date_debut = date("d/m/Y", strtotime(str_replace('/', '-', $cont[4])));
        echo "<tr>";
        echo "<td>".$cont[3]."</td>";
        echo "<td>".$cont[2]."</td>";
        echo "<td>".$date_debut."</td>";
        if ($date_fin){
            echo "<td>".$date_fin."</td>";
        }
        else{
            echo "<td><input name='date_fin' style='width:100px' class='form-control datepicker date_fin' id='$cont[0]' value=".$date_fin."></input></td>";
        }
        echo "<td><font size='4pt'><i id='save_affect_$cont[0]' style='color:#00a65a;opacity:0' class='glyphicon glyphicon-ok save_affect save_affect_$cont[0]'></i></font></td>";
        echo "<td><font size='4pt'><i id='$cont[0]' style='cursor:Pointer' class='glyphicon glyphicon-trash del-affect' id='del-affect'></i></font></td>";
        echo "</tr>";
    };
?>
    
    
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    </div>

<script type="text/javascript">
    
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'fr',
        autoclose: true
    });

    $('#list_affect').DataTable({
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
        info: true,
        'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [4, 5] /* 1st one, start by the right */
        }]
    });
    // var table = $('#list_affect').DataTable({
    //     'aoColumnDefs': [{
    //         'bSortable': false,
    //         'aTargets': [-1] /* 1st one, start by the right */
    //     }]
    // });

    $('.datepicker').on('change', function(e){
        val = this.value;
        if(val){
            dp_id=this.id;
            document.getElementById('save_affect_'+dp_id).style.opacity = 1;
            document.getElementById('save_affect_'+dp_id).style.cursor = 'pointer';
        }
        else{
            dp_id=this.id;
            document.getElementById('save_affect_'+dp_id).style.opacity = 0;
            document.getElementById('save_affect_'+dp_id).style.cursor = 'default';
        }
    });
        
    secure_affect();
    
    function add_line(){
        var arrayLignes = document.getElementById("list_affect").rows; //l'array est stocké dans une variable
        var longueur = arrayLignes.length;//Recherche de la longueur de tableau
        var ligne = document.getElementById("list_affect").insertRow(1);
        /*var colonne1 = ligne.insertCell(0);
        colonne1.innerHTML = "&nbsp;";*/
        var colonne2 = ligne.insertCell(0);
        colonne2.innerHTML = "<select name='client_new' class='form-control client_new' style='width:250px' id='client_new'></select>";
        var colonne3 = ligne.insertCell(1);
        colonne3.innerHTML = "<select name='contrat_new' class='form-control contrat_new' style='width:250px' id='contrat_new'></select>";
        var colonne4 = ligne.insertCell(2);
        colonne4.innerHTML = "<input name='new_date_debut' class='form-control datepicker' style='width:100px'  id='new_date_debut'></input>";
        $.ajax({
        type: "POST",
            url: "forms/admin/affect/req_gest_affect_all_cli.php",
            data: "client_id=0", // on envoie $_GET['go']
            datatype: "json", // on veut un retour JSON
            success: function(data) {
                $('#client_new').empty();
                $('#client_new').append('<option value="0"></option>');
                var list_cli = $.parseJSON(data);
                nb = 0;
                $.each($.parseJSON(data), function(index, value) {
                    $('#client_new').append('<option value="'+ list_cli[nb].index +'">'+ list_cli[nb].value +'</option>');
                    nb++;
                });
            }
        });
        var colonne5 = ligne.insertCell(3);
        colonne5.innerHTML = "<input style='width:100px' id='date_fin' value=''></input>";
        var colonne6 = ligne.insertCell(4);
        colonne6.innerHTML = "<font size='4pt'><i style='cursor:pointer;color:#00a65a;opacity:1' class='glyphicon glyphicon-ok save_affect_collab'></i></font>";
        // $('#new_date_debut').removeClass("hasDatepicker").addClass("form-control datepicker");
        document.getElementById("new_date_debut").className = "form-control datepicker";
        document.getElementById("date_fin").className = "form-control datepicker";
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'fr',
            autoclose: true
        });

    }

    
</script>