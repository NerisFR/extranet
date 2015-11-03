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
?>
<!-- DATA TABLES -->
<link href="./plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/TableTools/css/dataTables.tableTools.css" rel="stylesheet" type="text/css" />
<link href="./plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet" type="text/css" />

<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="col-xs-6 box-title">Gestions des clients</h3>
      <h3 class="col-xs-6 box-title add" id="btn-add" style="text-align: right;cursor:Pointer"><i class='glyphicon-plus'></i>Ajouter</h3>
    </div><!-- /.box-header -->
</div>

<!-- <div class="box box-primary">
    <form role="form" action="#" class="clients" id="clients">
        <div class="box-body">
            <div class="form-group">
                <div class="row">
                    <table align="center">
                        <tr>
                            <td width="90">Département</td>
                            <td width="100"><select name="departement" id="departement" class="departement">
                                <?php
                                    global $list_dep;
                                    echo "<option selected value='0'></option>";
                                    foreach($list_dep as $row){
                                        echo "<option value=$row[0]>$row[1] - $row[2]</option>";
                                    }
                                ?>
                            </select></td>
                            <td width="50"></td>
                            <td width="60">Région</td>
                            <td width="100"><select name="region" id="region" class="region">
                            <?php
                            global $list_reg;
                            echo "<option selected value='0'></option>";
                            foreach($list_reg as $row){
                                            echo "<option value=$row[0]>$row[1]</option>";
                            }
                            ?>
                            </select></td>
                            <td width="25"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div> -->

<div class="afficher container-fluid"></div>

<div class="modal fade" id="client" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Nouveau client</h3>
            </div>
            <div class="modal-body">
                <form data-ajax="false">
                    <div class="col-xs-6">
                        <span>Nom : </span>
                        <span>
                            <input class="form-control" name="client" id="nom_client" type="client"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Adresse : </span>
                        <span>
                            <input class="form-control" name="adresse" id="adresse" type="adresse"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Code Postal : </span>
                        <span>
                            <input class="form-control" name="cp" id="cp" type="CP"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Ville : </span>
                        <span>
                            <input class="form-control" name="ville" id="ville" type="ville"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Département : </span>
                        <span>
                            <select class="form-control" name="dep" id="dep" type="dep">
                            <?php
                                global $list_dep;
                                echo "<option selected value='0'></option>";
                                foreach($list_dep as $row){
                                    echo "<option value=$row[0]>$row[1] - $row[2]</option>";
                                }
                            ?>
                            </select>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span style='opacity:0'><input style='opacity:0' class="form-control" id="num_id_cli"></input></span>
                    </div>

                    <div class="col-xs-6">
                        <span>SIRET : </span>
                        <span>
                            <input class="form-control" name="siret" id="siret" type="text"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>&nbsp;</span>
                        <span style='opacity:0'>
                            <input style='opacity:0' class="form-control" name="text"></input>
                        </span>
                    </div>

                    <div class="col-xs-6">
                        <span>Téléphone : </span>
                        <span>
                            <input class="form-control" name="tel" id="tel" type="text"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Fax : </span>
                        <span>
                            <input class="form-control" name="fax" id="fax" type="text"></input>
                        </span>
                    </div>
                    
                    <div class="col-xs-6">
                        <span>Email : </span>
                        <span>
                            <input class="form-control" name="mail" id="mail" type="mail"></input>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <span>Site Web : </span>
                        <span>
                            <input class="form-control" name="web" id="web" type="web"></input>
                        </span>
                    </div>
                    <div class="col-xs-12">
                        <span>&nbsp;</span>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="bt_annul_cli" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="bt_modif_cli">Enregistrer</button>
                </div>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.example-modal -->        
</div>




<div class="modal fade" id="alert_cli" tabindex="-1" role="dialog">
    <div class="modal-danger">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Attention</h4>
          </div>
          <div class="modal-body">
            <p id="text_suppr_cli">One fine body&hellip;</p>
            <span style='opacity:0'><input id="id_suppr"></input></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" id="bt_alert_annul_cli">Annuler</button>
            <button type="button" class="btn btn-outline" id="bt_alert_suppr_cli">Suppr.</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->

<div class="modal fade" id="success_cli" tabindex="-1" role="dialog">
    <div class="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span >&times;</span></button>
            
            <h4 class="modal-title">Opération réussie</h4>
          </div>
          <div class="modal-body">
            <p id="text_success_cli">One fine body&hellip;</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-right" data-dismiss="modal" id="bt_success_cli">Ok</button>
            <!--<button type="button" class="btn btn-outline" id="bt_alert_suppr">Suppr.</button>-->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  </div><!-- /.example-modal -->


<script type="text/javascript" src="./forms/admin/client/ctrl_gest_client.js"></script>


<script type="text/javascript">
    $(function () {

        $('.datepicker').datepicker({
                    format: 'dd/mm/yyyy',
                    endDate: "today",
                    language: 'fr',
                    autoclose: true
                });
      });
      
    
</script>

