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

	$sql = "SELECT id, num, nom FROM departement ORDER BY num";
	$sth = $db->query($sql);
  	$list_dep = $sth->fetchall();

  	$myid = $_SESSION['auth']['myid'];

  	$sql = "SELECT id, region FROM region ORDER BY region";
	$str = $db->query($sql);
  	$list_reg = $str->fetchall();

    $sql = "SELECT DISTINCT clients.id, clients.nom FROM clients";
    $stcli = $db->query($sql);
    $list_cli = $stcli->fetchall();

?>
<!-- DATA TABLES -->
<link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Gestions des contrats</h3>
      <h3 class="col-xs-6 box-title add" id="btn-add" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>
    </div><!-- /.box-header -->
</div>

<div class="box box-primary">
    <form role="form" action="#" class="clients" id="clients">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <table align="center">
                        <tr>
                            <td width="90" height="30">Département</td>
                            <td width="100" height="30"><select name="departement" id="departement" class="departement">
                                <?php
                                    global $list_dep;
                                    echo "<option selected value='0'></option>";
                                    foreach($list_dep as $row){
                                                    echo "<option value=$row[0]>$row[1] - $row[2]</option>";
                                    }
                                ?>
                                </select>
                            </td>
                            <td width="25" height="30"></td>
                            <td width="60" height="30">Région</td>
                            <td width="100" height="30"><select name="region" id="region" class="region">
                                <?php
                                global $list_reg;
                                echo "<option selected value='0'></option>";
                                foreach($list_reg as $row){
                                                echo "<option value=$row[0]>$row[1]</option>";
                                }
                                ?>
                                </select>
                            </td>
                            <td width="25" height="30"></td>
                        </tr>
                        <tr>
                            <td width="90" height="30">Client</td>
                            <td width="100" height="30"><select name="client" id="client" class="client">
                            <?php
                                global $list_cli;
                                echo "<option selected value='0'></option>";
                                foreach($list_cli as $row){
                                        echo "<option value=$row[0]>$row[1]</option>";
                                }
                            ?>
                            </select></td>
                            <td></td>
                            <td colspan="2" width="160" height="30">
                                <INPUT id='status' type= "radio" name="status" value="encours" checked> En-cours
                                <INPUT id='status' type= "radio" name="status" value="resilie" > Résilié
                                <INPUT id='status' type= "radio" name="status" value="tous" > Tous
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="afficher container-fluid"></div>
<!-- <div class="popup hide">test</div> -->

<div class="modal fade" id="contrat" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Nouveau contrat</h3>
            </div>
            <div class="modal-body">
                <form data-ajax="false">
                    <div class="col-xs-12">
                        <span class='list'>Description : </span>
                        <span class='list'>
                            <input class="form-control" name="desc" id="desc"></input>
                        </span>
                        <span style='opacity:0' class="entete"><input id="num_id_cont"></input></span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span class='list'>Numéro : </span>
                        <span class='list'>
                                <input class="form-control" name="num" id="num"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span class='list'>Volume horaire: </span>
                        <span class='list'>
                                <input class="form-control" name="vol" id="vol"></input>
                        </span>
                    </div>

                    <div class="col-xs-6">
                        <span class='list'>Date de sign. : </span>
                        <span class='list'>
                                <input class="form-control datepicker" name="date_sign" id="date_sign"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span class='list'>Date de dém. : </span>
                        <span class='list'>
                                <input class="form-control datepicker" name="date_dem" id="date_dem"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span class='list'>Date de fin de mission : </span>
                        <span class='list'>
                                <input class="form-control datepicker" name="date_fin_mission" id="date_fin_mission"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                            <span class='list'>Durée du préavis : </span>
                            <span class='list'>
                                    <input class="form-control" name="preavis" id="preavis"></input>
                            </span>
                    </div>

                    <div class="col-xs-12 checkbox">
                        <label>
                            <input type='checkbox' id="marche" value="true" class="minimal"/> Marché public
                        </label>
                        <label>
                            <input type='checkbox' id="tacite" value="true" class="minimal"/> Reconduction tacite
                        </label>                      
                    </div>
                    
                    <div class="col-xs-6">
                        <span class='list'>Client : </span>
                        <span class='list'>
                            <select class="form-control" name="cli" id="cli">
                                <option value="0">             </option>
                                <?php
                                    global $list_cli;
                                    foreach($list_cli as $row){
                                    echo "<option value=$row[0]>$row[1]</option>";
                                    }
                                ?>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span >
                            <input style='opacity:0' class="form-control" name="test"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span class='list'>Base de calcul (nb semaine) : </span>
                        <span class='list'>
                            <select class="form-control" name="base_sem" id="base_sem">
                                <?php
                                    for($i=1;$i<44;$i++){
                                        echo "<option value=$i>$i</option>";
                                    }
                                ?>
                                <option value='45' selected>45</option>
                                <?php
                                    for($i=46;$i<52;$i++){
                                        echo "<option value=$i>$i</option>";
                                    }
                                ?>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Durée en mois : </span>
                        <span>
                            <select style="width:150px" class="form-control" name="nb_mois" id="nb_mois">
                                <?php
                                    for($i=1;$i<12;$i++){
                                        echo "<option value=$i>$i</option>";
                                    }
                                ?>
                                <option value='12' selected>12</option>
                            </select>
                        </span>
                    </div>
                    
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="bt_annul_cont" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary pull-right" id="bt_modif_cont">Enregistrer</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.example-modal -->        
</div>    
        
       
<div class="modal fade" id="alert_contrat" tabindex="-1" role="dialog">
    <div class="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Attention</h4>
          </div>
          <div class="modal-body">
            <p id="text_suppr_contrat">One fine body&hellip;</p>
            <span style='opacity:0'><input id="id_suppr"></input></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="bt_alert_annul_contrat">Annuler</button>
            <button type="button" class="btn btn-outline" id="bt_alert_suppr_contrat">Suppr.</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<div class="modal fade" id="success_contrat" tabindex="-1" role="dialog">
    <div class="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Opération réussie</h4>
          </div>
          <div class="modal-body">
            <p id="text_success_contrat">One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="bt_success_contrat">Ok</button>
            <!--<button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<script type="text/javascript" src="./forms/admin/contrat/ctrl_gest_contrat.js"></script>


<script type="text/javascript">
    $(function () {

        $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    language: 'fr',
                    autoclose: true
        });
        
        //iCheck for checkbox and radio inputs
        /*$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });*/
    });
      
    
</script>