<?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    $id_collab = $_POST['id_collab'];
    include '../../functions.php';
    global $db;

    $list_profils = $db->query("SELECT * FROM profils");
    $profils = $list_profils->fetchall();
    $list_profils->closeCursor();

?>


    <div class='row'>
    <div class='col-xs-12'>
    <div class='box'>
    <div class='box-header'>
    <h3 class='box-title'>Liste des profils</h3>
    </div>
    <div class='box-body'>
    <table id='list_profils' class='table table-bordered table-striped table-hover display nowrap' width='100%'>
    <thead>
    <tr>
    <th rowspan="2" style="vertical-align: middle">Profil</th>
    <th colspan="8" style="text-align: center">Autorisation</th>
    <th rowspan="2" colspan="2">&nbsp;</th>
    <th rowspan="2" style="vertical-align: middle; text-align:center"><font size='3pt'><i id='add_profils' onclick="ajout_ligne()" style='cursor:pointer;color:#3c8dbc' class='glyphicon glyphicon-plus-sign'></i></font></th>
    </tr>
    <tr>
    <!--<th >&nbsp;</th>-->
    <!--<th>Profil</th>-->
    <th>Notes de synthèse</th>
    <th>Tableau des heures</th>
    <th>Tableau des taches</th>
    <th>Gest. des collab.</th>
    <th>Gest. des clients</th>
    <th>Gest. des contrats</th>
    <th>Gest. des affectations</th>
    <th>Gest. des profils</th>
    <!-- <th >&nbsp;</th> -->
<!--     <th><font size='4pt'><i id='add_affect' style='cursor:pointer;color:#3c8dbc' class='glyphicon glyphicon-plus-sign'></i></font></th>
 --></tr>
    </thead>
    <tbody id='corp'>
    
        
<?php
    foreach ($profils as $pro) {

    	echo "<tr>";
        echo "<td><input size='15' name='pro$pro[0]' id='pro$pro[0]' disabled value=".$pro[1]."></input></td>";
        echo "<td><select name='nds$pro[0]' id='nds$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[2] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[2] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[2] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[2] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Tableaux des heures
        echo "<td><select name='tdbh$pro[0]' id='tdbh$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[3] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[3] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[3] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[3] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Tableaux des taches
        echo "<td><select name='tdbt$pro[0]' id='tdbt$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[4] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[4] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[4] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[4] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Gestion collab.
        echo "<td><select name='gcollab$pro[0]' id='gcollab$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[7] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[7] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[7] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[7] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Gestion clients
        echo "<td><select name='gclient$pro[0]' id='gclient$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[5] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[5] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[5] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[5] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //gestion contrats
        echo "<td><select name='gcontrat$pro[0]' id='gcontrat$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[6] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[6] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[6] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[6] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Gestion affectation
        echo "<td><select name='gaffect$pro[0]' id='gaffect$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[8] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[8] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[8] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[8] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";
        //Gestion profils
        echo "<td><select name='gprofils$pro[0]' id='gprofils$pro[0]' disabled>";
        echo "<option value='n' ";
            if($pro[9] == 'n'){echo "selected='selected'";}
        echo ">No Access</option>";
        echo "<option value='a' ";
            if($pro[9] == 'a'){echo "selected='selected'";}
        echo ">Full Access</option>";
        echo "<option value='r' ";
            if($pro[9] == 'r'){echo "selected='selected'";}
        echo ">Read</option>";
        echo "<option value='w' ";
            if($pro[9] == 'w'){echo "selected='selected'";}
        echo ">Write</option>";
        echo "</select></td>";

        echo "<td><font size='3pt'><i id='save_pro_$pro[0]' style='color:#00a65a;opacity:0' class='glyphicon glyphicon-ok save_pro save_pro_$pro[0]'></i></font></td>";
        echo "<td><font size='3pt'><i id='$pro[0]' style='cursor:Pointer' class='glyphicon glyphicon-edit edit_pro '></i></font></td>";
        echo "<td><font size='3pt'><i id='$pro[0]' style='cursor:Pointer' class='glyphicon glyphicon-trash del-pro'></i></font></td>";
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
    $('#list_profils').DataTable({
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
            ordering: false,
            info: true,
            'aoColumnDefs': [{
            'bSortable': false,
            'aTargets': [4, 5] /* 1st one, start by the right */
        }]
            
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

    function ajout_ligne(){
        var ligne = document.getElementById("list_profils").insertRow(2);
        var colonne1 = ligne.insertCell(0);
        colonne1.innerHTML = "<input name='new_profil' class='form-control' id='new_profil'></input>";
        var colonne2 = ligne.insertCell(1);
        colonne2.innerHTML = "<select name='new_nds' class='form-control' id='new_nds'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne3 = ligne.insertCell(2);
        colonne3.innerHTML = "<select name='new_tdbh' class='form-control' id='new_tdbh'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne4 = ligne.insertCell(3);
        colonne4.innerHTML = "<select name='new_tdbt' class='form-control' id='new_tdbt'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne5 = ligne.insertCell(4);
        colonne5.innerHTML = "<select name='new_gcollab' class='form-control' id='new_gcollab'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne6 = ligne.insertCell(5);
        colonne6.innerHTML = "<select name='new_gclient' class='form-control' id='new_gclient'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne7 = ligne.insertCell(6);
        colonne7.innerHTML = "<select name='new_gcontrat' class='form-control' id='new_gcontrat'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne8 = ligne.insertCell(7);
        colonne8.innerHTML = "<select name='new_gaffect' class='form-control' id='new_gaffect'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne9 = ligne.insertCell(8);
        colonne9.innerHTML = "<select name='new_gprofils' class='form-control' id='new_gprofils'><option value='n' selected='selected'>No Access</option><option value='a'>Full Access</option><option value='r'>Read</option><option value='w'>Write</option></select>";
        var colonne10 = ligne.insertCell(9);
        colonne10.innerHTML = "<font size='4pt'><i style='cursor:pointer;color:#00a65a;opacity:1' class='glyphicon glyphicon-ok new_save_pro'></i></font>";
        return false;
    }
     
    
</script>