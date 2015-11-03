$(function() {

	$('document').ready(function(){
            affich_collab();
 	});

    Number.prototype.padLeft = function(base,chr){
        var  len = (String(base || 10).length - String(this).length)+1;
        return len > 0? new Array(len).join(chr || '0')+this : this;
    }

 	$(document).on('change','.departement',function (){
            document.getElementById('region').selectedIndex = 0;
            affich_collab();
        });

 	$(document).on('click','.edit-collab',function(){
            $("#collab").modal("show");
            var collab_id = this.id;
            $.ajax({
                type: "POST",
                url: "forms/admin/collab/req_gest_collab_id.php",
                data: "collab_id="+collab_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_collab = JSON.parse(data);
                    var embauche = new Date(list_collab["embauche"]);
                    var debauche = new Date(list_collab["debauche"]);
                    document.getElementById('collab_id').value = collab_id;
                    document.getElementById('civ').value = list_collab["civilite"];
                    document.getElementById('nom').value = list_collab["nom"];
                    document.getElementById('prenom').value = list_collab["prenom"];
                    document.getElementById('fonction').value = list_collab["fonction"];
                    document.getElementById('arrivee').value = embauche.getDate().padLeft() + '/' + (embauche.getMonth() + 1).padLeft() + '/' + embauche.getFullYear();
                    if (list_collab["debauche"] != null){
                        document.getElementById('depart').value = debauche.getDate().padLeft() + '/' + (debauche.getMonth() + 1).padLeft() + '/' + debauche.getFullYear();
                    }
                    document.getElementById('loggin').value = list_collab["login"];
                    document.getElementById('passwd').value = list_collab["password"];
                    // if (list_collab["admin"] == "true"){
                    //     document.getElementById('admin').checked = true;
                    // }
                    document.getElementById('profil').value = list_collab["id_profils"];
                    document.getElementById('bt_modif_collab').innerHTML = "Mettre à jour";
                }
            });
            affich_collab();
        });

	$(document).on('click','.view-collab',function(){
            $("#collab").modal("show");
            var collab_id = this.id;
            $.ajax({
        	type: "POST",
                url: "forms/admin/collab/req_gest_collab_id.php",
                data: "collab_id="+ collab_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_collab = JSON.parse(data);
                    document.getElementById('civ').value = list_collab["civilite"];
                    document.getElementById('nom').value = list_collab["nom"];
                    document.getElementById('prenom').value = list_collab["prenom"];
                    document.getElementById('fonction').value = list_collab["fonction"];
                    document.getElementById('arrivee').value = list_collab["embauche"];
                    if (list_collab["debauche"] != null){
                            document.getElementById('depart').value = list_collab["debauche"];
                    }
                    document.getElementById('loggin').value = list_collab["login"];
                    document.getElementById('passwd').value = list_collab["password"];
                    // if (list_collab["admin"] == "true"){
                    //         document.getElementById('admin').checked = true;
                    // }
                    document.getElementById('profil').value = list_collab["id_profils"];
                    document.getElementById('bt_modif_collab').innerHTML = "Imprimer";
                    document.getElementById('nom').disabled = true;
                    document.getElementById('prenom').disabled = true;
                    document.getElementById('fonction').disabled = true;
                    document.getElementById('arrivee').disabled = true;
                    document.getElementById('depart').disabled = true;
                    document.getElementById('loggin').disabled = true;
                    document.getElementById('passwd').disabled = true;
                    document.getElementById('admin').disabled = true;
                    document.getElementById('profil').disabled=true;
                }
            });
        });

	$(document).on('click','.del-collab',function(){
            $("#alert_collab").modal("show");
            var collab_id = this.id;
            $.ajax({
                type: "POST",
                url: "forms/admin/collab/req_gest_collab_id.php",
                data: "collab_id="+ collab_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    var list_collab = JSON.parse(data);
                    var nom_collab = list_collab["nom_usage"];
                    document.getElementById('text_suppr_cli').innerHTML = "Etes-vous sur de vouloir supprimer <b>"+nom_collab+"</b> de la liste des collaborateurs ? <span><input style='opacity:0' id='id_collab_suppr' value='"+collab_id+"'></input></span>";
                }
            });
        });

	$(document).on('click','.add',function(){
            $("#collab").modal("show");
        });
        
        $(document).on('click','#bt_modif_collab',function(){
            if (document.getElementById("bt_modif_collab").innerHTML === "Mettre à jour"){
                var collab_id = $('#collab_id').val();
                var civ = $('#civ').val();
                var nom = $('#nom').val();
                var prenom = $('#prenom').val();
                var fonction = $('#fonction').val();
                var arrivee = $('#arrivee').val();
                var depart = $('#depart').val();
                var loggin = $('#loggin').val();
                var passwd = $('#passwd').val();
                var id_profil = $('#profil').val();
                $.post('forms/admin/collab/modif_collab.php',{collab_id:collab_id,civ:civ,nom:nom,prenom:prenom,fonction:fonction,arrivee:arrivee,depart:depart,
                loggin:loggin,passwd:passwd,id_profil:id_profil},function(data) {
                    $("#collab").modal("hide");
                    $('#text_success_collab').html(data);
                    $("#success_collab").modal("show");
                });
                setTimeout(function(){	
                    RAZ_collab();
                }, 2000);
                Affich_collab();
                return false;
            }
            else if (document.getElementById("bt_modif_collab").innerHTML === "Imprimer") {
                RAZ_client();
                $("#collab").modal("hide");
            }
            else if (document.getElementById("bt_modif_collab").innerHTML === "Enregistrer") {
                var civ = $('#civ').val();
                var nom = $('#nom').val();
                var prenom = $('#prenom').val();
                var fonction = $('#fonction').val();
                var arrivee = $('#arrivee').val();
                var depart = $('#depart').val();
                var loggin = $('#loggin').val();
                var passwd = $('#passwd').val();
                var id_profil = $('#profil').val();
                $.post('forms/admin/collab/req_collab_add.php',{civ:civ,nom:nom,prenom:prenom,fonction:fonction,arrivee:arrivee,depart:depart,
                loggin:loggin,passwd:passwd,id_profil:id_profil},function(data) {
                    $("#collab").modal("hide");
                    $('#text_success_collab').html(data);
                    $("#success_collab").modal("show");
                });
                setTimeout(function(){	
//                    RAZ_collab();
                }, 2000);
                affich_collab();
                return false;
            }
        });

 	$(document).on('click','.close',function(){
            RAZ_collab();
 	});
        
        $(document).on('click','#bt_annul_collab',function(){
            RAZ_collab();
 	});
        
        $(document).on('click','#bt_alert_suppr_collab',function(){
            var collab_id = document.getElementById('id_collab_suppr').value;
            $.ajax({
        	type: "POST",
                url: "forms/admin/collab/req_collab_del.php",
                data: "collab_id="+collab_id, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $("#alert_collab").modal("hide");
                    $('#text_success_collab').html(data);
                    $("#success_collab").modal("show");
                }
            });
            setTimeout(function(){	
                $("#success_collab").modal("hide");
            }, 2000);
            affich_collab();
            return false;
 	});

        function RAZ_collab(){
            document.getElementById('civ').value = "";
            document.getElementById('nom').value = "";
            document.getElementById('prenom').value = "";
            document.getElementById('fonction').value = "";
            document.getElementById('arrivee').value = "";
            document.getElementById('depart').value = "";
            document.getElementById('loggin').value = "";
            document.getElementById('passwd').value = "";
            document.getElementById('profil').value = "";
            document.getElementById('civ').disabled = false;
            document.getElementById('nom').disabled = false;
            document.getElementById('prenom').disabled = false;
            document.getElementById('fonction').disabled = false;
            document.getElementById('arrivee').disabled = false;
            document.getElementById('depart').disabled = false;
            document.getElementById('loggin').disabled = false;
            document.getElementById('passwd').disabled = false;
            document.getElementById('admin').disabled = false;
            document.getElementById('profil').disabled = false;
            document.getElementById('bt_modif_collab').innerHTML = "Enregistrer";
        }
        
        function affich_collab(){
            var id_departement = $('.departement').val();
            $.ajax({
        	type: "POST",
                url: "forms/admin/collab/req_gest_collab.php",
                data: "id_departement="+ id_departement, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $('.afficher').html(data);
                    secure_collab();
                }
            });
        }
});