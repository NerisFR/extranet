<?php
    session_start();
    require("../../../auth.php");
    if(Auth::isLogged()){

    }
    else{
            header('Location:forms/404.php');
    }
    include '../../functions.php';
    global $db;

    // $today = date("Y-m-d");
    // $sql = "SELECT id, nom_usage FROM collaborateurs  ORDER BY nom_usage ";
    // $sth = $db->query($sql);
    // $list_collab = $sth->fetchall();
    
    $sql = "SELECT id, nom FROM clients ORDER BY nom";
    $sth = $db->query($sql);
    $list_cli = $sth->fetchall();

    // $myid = $_SESSION['auth']['id_client'];

    // $sql = "SELECT id, description FROM contrats ORDER BY description";
    // $str = $db->query($sql);
    // $list_cont = $str->fetchall();
?>
<!-- DATA TABLES -->
<link href="./plugins/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />

<div class="box box-primary" id="test">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Gestions des utilisateurs Clients</h3>
<!--      <h3 class="col-xs-6 box-title add" id="btn-add" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>-->
    </div><!-- /.box-header -->
</div>

<div class="box box-primary">
    <form role="form" action="#" id="filtre">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <table align="center">
                        <tr>
                            <td width="90">Client</td>
                            <td width="100"><select name="client_usercli" id="client_usercli">
                                <?php
                                global $list_cli;
                                echo "<option selected value='0'></option>";
                                foreach($list_cli as $row){
                                    echo "<option value=$row[0]>$row[1]</option>";
                                }
                                ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="afficher container-fluid">
    
</div>

<div class="modal fade" id="alert_usercli" tabindex="-1" role="dialog">
    <div class="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Attention</h4>
          </div>
          <div class="modal-body">
            <p id="text_suppr_usercli">One fine body&hellip;</p>
            <span style='opacity:0'><input id="id_usercli_suppr"></input></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="bt_alert_annul_usercli">Annuler</button>
            <button type="button" class="btn btn-outline" id="bt_alert_suppr_usercli">Suppr.</button>
          </div>
        </div> 
      </div>
    </div>  
  </div> 

<div class="modal fade" id="success_usercli" tabindex="-1" role="dialog">
    <div class="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Opération réussie</h4>
          </div>
          <div class="modal-body">
            <p id="text_success_usercli">One fine body&hellip;</p>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="bt_success_usercli">Ok</button>
<!--            <button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>-->
          </div>
        </div>  
      </div>  
    </div>  
</div> 

<script type="text/javascript" src="./forms/admin/usercli/ctrl_gest_usercli.js"></script>
