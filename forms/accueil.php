<?php
  //   session_start();
  //   require("extranet/auth.php");
  //   if(Auth::isLogged()){
      
  //   }
  //   else{
  //     header('Location:forms/404.php');
  //   }

  // require_once("functions.php");
  // global $db;

  // $sql = "SELECT id, nom_usage FROM collaborateurs ORDER BY nom_usage";
  // $sth = $db->query($sql);
  // $list_collab = $sth->fetchall();

  // $myid = $_SESSION['auth']['myid'];
  
?>
    

<script src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="./forms/ctrl_accueil.js"></script>
<script type="text/javascript" src="./src/assets/canvasjs-1.6.2/canvasjs.min.js"></script>

<!-- <link rel="stylesheet" type="text/css" href="/extranet/src/css/app.css"> -->
<div class="row" id="WidgHours">

</div>

<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <div class="box box-success">
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <h3 class="box-title">Mes dernères notes de synthèses</h3>
                <div class="box-tools pull-right">
                    <ul class="pagination pagination-sm inline">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <div class="afficher" id="listNDS"></div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </section>


    <section class="col-lg-6 connectedSortable">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Newz</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="listnews"></div>
        <?php
          if($_SESSION['auth']['gest_profils'] == "a"){
            echo "<div class='input-group'>";
              echo "<input class='form-control' id='comment' placeholder='Ajouter...' />";
              echo "<div class='input-group-btn'>";
                echo "<button class='btn btn-success' id='btn_add_news'><i class='fa fa-plus'></i></button>";
              echo "</div>";
            echo "</div>";
          }
        
        ?>
        <div class="box-footer text-center">
          <a href='#' class='uppercase'>Afficher toutes les news</a>
        </div><!-- /.box-footer -->
      </div><!-- /.box -->
    </section><!-- /.content -->
  <!-- </div>/.content-wrapper -->

</div>
