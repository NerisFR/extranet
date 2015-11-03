$(function() {

	$('document').ready(function(){
            affich_affect_collab();
 	});
        
        $(document).on('change','#collab',function (){
            var id_collab = $('#collab').val();
            document.getElementById('client').selectedIndex=0;
            document.getElementById('contrat_affect').selectedIndex=0;
            affich_affect_collab();
        });
        
        $(document).on('change','#client',function (){
            var client_id = $('#client').val();
            document.getElementById('collab').selectedIndex=0;
            document.getElementById('contrat_affect').selectedIndex=0;
            $.ajax({
        	type: "POST",
                    url: "forms/admin/affect/req_contrats.php",
                    data: "client_id="+client_id, // on envoie $_GET['go']
                    datatype: "json", // on veut un retour JSON
                    success: function(data) {
                        $('#contrat_affect').empty();
                        $('#contrat_affect').append('<option value="0"></option>');
                        var list_contrat = $.parseJSON(data);
                        nb = 0;
                        $.each($.parseJSON(data), function(index, value) {
                            $('#contrat_affect').append('<option value="'+ list_contrat[nb].index +'">'+ list_contrat[nb].value +'</option>');
                            nb++;
                        });
                    }
            });
        });
        
        $(document).on('change','#contrat_affect',function (){
            var id_contrat = $('#contrat_affect').val();
            document.getElementById('collab').selectedIndex=0;
            affich_affect_contrat();
        });

	$(document).on('click','.save_affect',function(){
            affect = this.id;
            var elem = affect.split('_');
            affect_id = elem[2];
            date_fin = document.getElementById(affect_id).value;
            $.post('forms/admin/affect/req_gest_affect_modif.php',{affect_id:affect_id,date_fin:date_fin},function(data) {
                    $('#text_success_affect').html(data);
                    $("#success_affect").modal("show");
                });
                setTimeout(function(){	
                    $("#success_affect").modal("hide");
                }, 2000);
            var id_contrat = $('#contrat_affect').val();
            if (id_contrat!=0){
                affich_affect_contrat();
            }
            else{
                affich_affect_collab();
            }
                return false;
        });
        
        $(document).on('click','.save_affect_collab',function(){
            id_collab = document.getElementById("collab").value;
            contrat_id = document.getElementById("contrat_new").value;
            date_debut = document.getElementById("new_date_debut").value;
            date_fin = document.getElementById("date_fin").value; 

            
            
            $.post('forms/admin/affect/req_gest_affect_add.php',{id_collab:id_collab,contrat_id:contrat_id,date_debut:date_debut,date_fin:date_fin},function(data) {
                    $('#text_success_affect').html(data);
                    $("#success_affect").modal("show");
                });
                setTimeout(function(){	
                    $("#success_affect").modal("hide");
                }, 2000);
            var id_contrat = $('#contrat_affect').val();
            if (id_contrat!=0){
                affich_affect_contrat();
            }
            else{
                affich_affect_collab();
            }
                return false;
        });

	/*$(document).on('click','#add_affect',function(){
            var arrayLignes = document.getElementById("list_affect").rows; //l'array est stocké dans une variable
            var longueur = arrayLignes.length;//Recherche de la longueur de tableau
            var ligne = document.getElementById("list_affect").insertRow(1);
            var colonne1 = ligne.insertCell(0);
            colonne1.innerHTML = "&nbsp;";
            var colonne2 = ligne.insertCell(1);
            colonne2.innerHTML = "<select name='client_new' class='form-control client_new' style='width:250px' id='client_new'></select>";
            var colonne3 = ligne.insertCell(2);
            colonne3.innerHTML = "<select name='contrat_new' class='form-control contrat_new' style='width:250px' id='contrat_new'></select>";
            var colonne4 = ligne.insertCell(3);
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
            var colonne5 = ligne.insertCell(4);
            colonne5.innerHTML = "<input style='width:100px' class='form-control datepicker' id='date_fin' value=''></input>";
            var colonne6 = ligne.insertCell(5);
            colonne6.innerHTML = "<font size='4pt'><i style='cursor:pointer;color:#00a65a;opacity:1' class='glyphicon glyphicon-ok save_affect_collab'></i></font>";
            $('#new_date_debut').removeClass("hasDatepicker").addClass("form-control datepicker");
            $('#date_fin').removeClass("hasDatepicker").addClass("form-control datepicker");
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'fr',
                autoclose: true
            });
            
        });*/
        
        $(document).on('change','#collab_new',function(){
            id_collab = document.getElementById("collab_new").value;
//            alert(id_collab);
            $.ajax({
        	type: "POST",
                    url: "forms/admin/affect/req_gest_affect_fonction_collab.php",
                    data: "id_collab="+id_collab, // on envoie $_GET['go']
                    datatype: "json", // on veut un retour JSON
                    success: function(data) {
                        var list_cli = $.parseJSON(data);
                        document.getElementById("fonction").value = list_cli[0].value;
                        
                    }
            });
        });
        
        /*$(document).on('click','#add_affect_cont',function(){
            var arrayLignes = document.getElementById("list_affect").rows; //l'array est stocké dans une variable
            var longueur = arrayLignes.length;//Recherche de la longueur de tableau
            alert(longueur);
            var ligne = document.getElementById("list_affect").insertRow(1);
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
            
        });
*/
        $(document).on('change','#client_new',function (){
            var client_id = $('#client_new').val();
            document.getElementById('contrat_new').selectedIndex=0;
            $.ajax({
        	type: "POST",
                    url: "forms/admin/affect/req_contrats.php",
                    data: "client_id="+client_id, // on envoie $_GET['go']
                    datatype: "json", // on veut un retour JSON
                    success: function(data) {
                        $('#contrat_new').empty();
                        $('#contrat_new').append('<option value="0"></option>');
                        var list_contrat = $.parseJSON(data);
                        nb = 0;
                        $.each($.parseJSON(data), function(index, value) {
                            $('#contrat_new').append('<option value="'+ list_contrat[nb].index +'">'+ list_contrat[nb].value +'</option>');
                            nb++;
                        });
                    }
            });
        });
      
        $(document).on('click','.del-affect',function (){
            $("#alert_affect").modal("show");
            var affect_id = this.id;
            document.getElementById('id_affect_suppr').value = affect_id;
            document.getElementById("text_suppr_affect").innerHTML = "Etes-vous sur de vouloir supprimer l'affectation n°"+affect_id;
        });
               
        $(document).on('click','#bt_alert_suppr_affect',function(){
            var affect_id = document.getElementById('id_affect_suppr').value;
            $.ajax({
        	type: "POST",
                url: "forms/admin/affect/req_affect_del.php",
                data: "affect_id="+affect_id, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $("#alert_affect").modal("hide");
                    $('#text_success_affect').html(data);
                    $("#success_affect").modal("show");
                }
            });
            setTimeout(function(){	
                $("#success_affect").modal("hide");
            }, 2000);
            if (id_contrat!=0){
                affich_affect_contrat();
            }
            else{
                affich_affect_collab();
            }
            return false;
 	});


        function affich_affect_collab(){
            var id_collab = $('#collab').val();

            $.ajax({
        	type: "POST",
                url: "forms/admin/affect/req_gest_affect.php",
                data: "id_collab="+id_collab, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $('.afficher').html(data);
                }
            });
            // secure_affect();
        }
        
        function affich_affect_contrat(){
            var id_contrat = $('#contrat_affect').val();
            $.ajax({
        	type: "POST",
                url: "forms/admin/affect/req_gest_affect_contrat.php",
                data: "id_contrat="+id_contrat, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $('.afficher').html(data);
                }
            });
            // secure_affect();
        }
        
        
    
});