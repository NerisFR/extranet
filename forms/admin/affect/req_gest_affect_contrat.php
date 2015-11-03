<?php

$id_contrat = mysql_real_escape_string($_POST['id_contrat']);

$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
$req = "SELECT affect_cont_collab.id, collaborateurs.nom_usage, collaborateurs.prenom, collaborateurs.fonction, affect_cont_collab.debut, affect_cont_collab.fin, contrats.id FROM contrats INNER JOIN (collaborateurs INNER JOIN affect_cont_collab ON collaborateurs.id = affect_cont_collab.id_collab) ON contrats.id = affect_cont_collab.id_contrat WHERE (((contrats.id)=".$id_contrat."))";
$list_collab = $db->query($req);
$collabs = $list_collab->fetchall();
?>

    <div class='row'>
    <div class='col-xs-12'>
    <div class='box'>
    <div class='box-header'>
    <h3 class='box-title'>Liste des clients</h3>
    </div>
    <div class='box-body'>
    <table id='list_affect_cont' class='table table-bordered table-striped table-hover display nowrap'>
    <thead>
    <tr>
    <th>Collaborateur</th>
    <th>Fonction</th>
    <th>Début d'affectation</th>
    <th>Fin d'affectation</th>
    <th>&nbsp;</th>
    <th  style="text-align:center"><font size='4pt'><i id='add_affect_cont' onclick="add_line()" style='cursor:pointer;color:#3c8dbc' class='glyphicon glyphicon-plus-sign'></i></font></th>
    </tr>
    </thead>
    <tbody id='corp'>
    

<?php
    foreach ($collabs as $col) {
        if($col[5]){
            $date_fin = date("d/m/Y", strtotime(str_replace('/', '-', $col[5])));
        }
        else{
            $date_fin = "";
        }
        echo "<tr>";
        echo "<td>".$col[1]."</td>";
        echo "<td>".$col[3]."</td>";
        echo "<td>".$col[4]."</td>";
//        echo "<td>".$col[5]."</td>";
        if ($date_fin){
            echo "<td>".$date_fin."</td>";
        }
        else{
            echo "<td><input name='date_fin' style='width:100px' class='form-control datepicker date_fin' id='$col[0]' value=".$date_fin."></input></td>";
        }
        echo "<td><font size='4pt'><i id='save_affect_$col[0]' style='color:#00a65a;opacity:0' class='glyphicon glyphicon-ok save_affect save_affect_$col[0]'></i></font></td>";
        echo "<td><font size='4pt'><i id='$col[0]' style='cursor:Pointer' class='glyphicon glyphicon-trash del-affect'></i></font></td>";
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
    $('#list_affect_cont').DataTable({
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

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'fr',
            autoclose: true
        });
    secure_affect();

    function add_line(){
        var arrayLignes = document.getElementById("list_affect").rows; //l'array est stocké dans une variable
            var longueur = arrayLignes.length;//Recherche de la longueur de tableau
            var ligne = document.getElementById("list_affect").insertRow(1);
            /*var colonne1 = ligne.insertCell(0);
            colonne1.innerHTML = "&nbsp;";*/
            var colonne2 = ligne.insertCell(0);
            colonne2.innerHTML = "<select name='collab_new' class='form-control collab_new' style='width:250px' id='collab_new'></select>";
            var colonne3 = ligne.insertCell(1);
            colonne3.innerHTML = "<input name='fonction' class='form-control' style='width:200px'  id='fonction'></input>";
            var colonne4 = ligne.insertCell(2);
            colonne4.innerHTML = "<input name='new_date_debut' class='form-control datepicker' style='width:100px'  id='new_date_debut'></input>";
            $.ajax({
            type: "POST",
                url: "forms/admin/affect/req_gest_affect_all_collab.php",
                data: "client_id=0", // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    $('#collab_new').empty();
                    $('#collab_new').append('<option value="0"></option>');
                    var list_collab = $.parseJSON(data);
                    nb = 0;
//                    alert(list_collab);
                    $.each($.parseJSON(data), function(index, value) {
                        $('#collab_new').append('<option value="'+ list_collab[nb].index +'">'+ list_collab[nb].value +'</option>');
                        nb++;
                    });
                }
            });
            var colonne5 = ligne.insertCell(3);
            colonne5.innerHTML = "<input style='width:100px' class='form-control datepicker' id='date_fin' value=''></input>";
            var colonne6 = ligne.insertCell(4);
            colonne6.innerHTML = "<font size='4pt'><i style='cursor:pointer;color:#00a65a;opacity:1' class='glyphicon glyphicon-ok save_affect_contrat'></i></font>";
            $('#new_date_debut').removeClass("hasDatepicker").addClass("form-control datepicker");
            $('#date_fin').removeClass("hasDatepicker").addClass("form-control datepicker");
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'fr',
                autoclose: true
            });
    }
      
    
</script>

