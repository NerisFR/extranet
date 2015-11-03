$(function() {

	$('document').ready(function(){
            var collab_id = myid;
            Affich_clients();
 	});

 	$(document).on('change','.departement',function (){
            document.getElementById('region').selectedIndex=0;
            Affich_clients();
        });

    $(document).on('change','.region',function (){
            document.getElementById('departement').selectedIndex=0;
            Affich_clients();
        });

 	$(document).on('click','.del-cli',function(){
            $("#alert_cli").modal("show");
            var client_id = this.id;
            $.ajax({
                type: "POST",
                url: "forms/admin/client/req_gest_client_id.php",
                data: "client_id="+ client_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_client = JSON.parse(data);
                    var nom_cli = list_client["nom"];
                    document.getElementById('text_suppr_cli').innerHTML = "Etes-vous sur de vouloir supprimer le client : "+nom_cli+"? <span><input style='opacity:0' id='id_cli_suppr' value='"+client_id+"'></input></span>";
                }
            });
            Affich_clients();
        });

 	$(document).on('click','.edit-cli',function(){
            $("#client").modal("show");
            var client_id = this.id;
            $.ajax({
                type: "POST",
                url: "forms/admin/client/req_gest_client_id.php",
                data: "client_id="+ client_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_client = JSON.parse(data);
                    document.getElementById('nom_client').value = list_client["nom"];
                    document.getElementById('cp').value = list_client["cp"];
                    document.getElementById('adresse').value = list_client["adresse"];
                    document.getElementById('ville').value = list_client["ville"];
                    document.getElementById('dep').value = list_client["id_dep"];
                    // document.getElementById('region').value = list_client["region"];
                    document.getElementById('tel').value = list_client["tel"];
                    document.getElementById('web').value = list_client["web"];
                    document.getElementById('mail').value = list_client["mail"];
                    document.getElementById('fax').value = list_client["fax"];
                    document.getElementById('num_id_cli').value = list_client["id"];
                    document.getElementById('bt_modif_cli').innerHTML = "Mettre à jour";
                }
            });
        });

	$(document).on('click','.view-cli',function(){
            $("#client").modal("show");
            var client_id = this.id;
            $.ajax({
        	type: "POST",
                url: "forms/admin/client/req_gest_client_id.php",
                data: "client_id="+ client_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_client = JSON.parse(data);
                    // console.info[data];
                    document.getElementById('nom_client').value = list_client["nom"];
                    document.getElementById('cp').value = list_client["cp"];
                    document.getElementById('adresse').value = list_client["adresse"];
                    document.getElementById('ville').value = list_client["ville"];
                    document.getElementById('dep').value = list_client["id_dep"];
                    // document.getElementById('region').value = list_client["region"];
                    document.getElementById('tel').value = list_client["tel"];
                    document.getElementById('web').value = list_client["web"];
                    document.getElementById('mail').value = list_client["mail"];
                    document.getElementById('fax').value = list_client["fax"];
                    document.getElementById('nom_client').disabled = true;
                    document.getElementById('cp').disabled = true;
                    document.getElementById('adresse').disabled = true;
                    document.getElementById('ville').disabled = true;
                    document.getElementById('dep').disabled = true;
                    document.getElementById('region').disabled = true;
                    document.getElementById('tel').disabled = true;
                    document.getElementById('web').disabled = true;
                    document.getElementById('mail').disabled = true;
                    document.getElementById('fax').disabled = true;
                    document.getElementById('siret').disabled = true;
                    document.getElementById('bt_modif_cli').innerHTML = "Imprimer";
                }
            });
        });

	$(document).on('click','#bt_modif_cli',function(){
            if (document.getElementById("bt_modif_cli").innerHTML == "Mettre à jour"){
//                Test OK
                var nom_client = $('#nom_client').val();
                var cp_client = $('#cp').val();
                var adresse_client = $('#adresse').val();
                var ville_client = $('#ville').val();
                var SIRET_client = $('#siret').val();
                var dep_client = $('#dep').val();
                var tel_client = $('#tel').val();
                var web_client = $('#web').val();
                var mail_client = $('#mail').val();
                var fax_client = $('#fax').val();
                var id_client = document.getElementById('num_id_cli').value;
                $.post('forms/admin/client/modif_cli.php',{id_client:id_client,nom_client:nom_client,cp_client:cp_client,adresse_client:adresse_client,ville_client:ville_client,dep_client:dep_client,tel_client:tel_client,
                web_client:web_client,mail_client:mail_client,fax_client:fax_client,SIRET_client:SIRET_client},function(data) {
                    $("#client").modal("hide");
                    $('#text_success_cli').html(data);
                    $("#success_cli").modal("show");
                });
                setTimeout(function(){	
                    RAZ_client();
                    $("#success_cli").modal("hide");
                    Affich_clients();
                }, 2000);
                
                return false;
            }
            else if (document.getElementById("bt_modif_cli").innerHTML == "Imprimer"){
                RAZ_client();
            }
            else if (document.getElementById("bt_modif_cli").innerHTML == "Enregistrer"){
//                alert("test");
//                Test OK
                var nom_client = $('#nom_client').val();
                var cp_client = $('#cp').val();
                var adresse_client = $('#adresse').val();
                var ville_client = $('#ville').val();
                var SIRET_client = $('#siret').val();
                var dep_client = $('#dep').val();
                var tel_client = $('#tel').val();
                var web_client = $('#web').val();
                var mail_client = $('#mail').val();
                var fax_client = $('#fax').val();
                
                $.post('forms/admin/client/req_client_add.php',{nom_client:nom_client,cp_client:cp_client,adresse_client:adresse_client,ville_client:ville_client,dep_client:dep_client,tel_client:tel_client,
                web_client:web_client,mail_client:mail_client,fax_client:fax_client,SIRET_client:SIRET_client},function(data) {
                    $("#client").modal("hide");
                    $('#text_success_cli').html(data);
                    $("#success_cli").modal("show");
                });
                setTimeout(function(){	
                   RAZ_client();
                   $("#success_cli").modal("hide");
                   Affich_clients();
                }, 2000);
                return false;
            }
        });

	$('#btn-add').on('click',function(){
            $("#client").modal("show");
        });

 	$(document).on('click','.close-cli',function(){
            RAZ_client();
 	});

 	$(document).on('click','#bt_annul_cli',function(){
            RAZ_client();
 	});
        
    $(document).on('click','#bt_alert_suppr_cli',function(){
        var client_id = document.getElementById('id_cli_suppr').value;
        $.ajax({
    	type: "POST",
            url: "forms/admin/client/req_client_del.php",
            data: "client_id="+ client_id, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $("#alert_cli").modal("hide");
                $('#text_success_cli').html(data);
                $("#success_cli").modal("show");
            }
        });
        setTimeout(function(){	
            $("#success_cli").modal("hide");
            Affich_clients();
        }, 2000);
        return false;
 	});

        function RAZ_client(){
            document.getElementById('nom_client').value = "";
            document.getElementById('cp').value = "";
            document.getElementById('adresse').value = "";
            document.getElementById('ville').value = "";
            document.getElementById('dep').value = "";
            // document.getElementById('region').value = "";
            document.getElementById('tel').value = "";
            document.getElementById('web').value = "";
            document.getElementById('mail').value = "";
            document.getElementById('fax').value = "";
            document.getElementById('siret').value = "";
            document.getElementById('nom_client').disabled = false;
            document.getElementById('cp').disabled = false;
            document.getElementById('adresse').disabled = false;
            document.getElementById('ville').disabled = false;
            document.getElementById('dep').disabled = false;
            // document.getElementById('region').disabled = false;
            document.getElementById('tel').disabled = false;
            document.getElementById('web').disabled = false;
            document.getElementById('mail').disabled = false;
            document.getElementById('fax').disabled = false;
            document.getElementById('siret').disabled = false;
            document.getElementById('bt_modif_cli').innerHTML = "Enregistrer";
        }
        
    function Affich_clients(){
        var id_departement = $('.departement').val();
        var id_region = $('.region').val();
        $.post('forms/admin/client/req_gest_client.php',{id_departement:id_departement,id_region:id_region},function(data) {
            $('.afficher').html(data);
            secure_client();
        });        
    }
});