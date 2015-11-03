$(function() {

    $(document).ready(function(){ //OK
        affich_contrat();
    });

    $(document).on('change','input:radio',function (){
        var id_departement = $('.departement').val();
        var id_client = $('.client').val();
        var id_region = $('.region').val();
        status = $('input[type=radio][name=status]:checked').attr('value');
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat.php",
            data: "id_departement="+ id_departement+"&status="+status+"&id_client="+id_client+"&id_region="+id_region, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    });

    $(document).on('change','.departement',function (){
        var id_departement = $('.departement').val();
        document.getElementById('region').selectedIndex = 0;
        document.getElementById('client').selectedIndex = 0;
        status = $('input[type=radio][name=status]:checked').attr('value');
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat.php",
            data: "id_departement="+ id_departement+"&status="+status, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    });

    $(document).on('change','.client',function (){
        var id_client = $('.client').val();
        document.getElementById('region').selectedIndex = 0;
        document.getElementById('departement').selectedIndex = 0;
        status = $('input[type=radio][name=status]:checked').attr('value');
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat.php",
            data: "id_client="+ id_client+"&status="+status, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    });

    $(document).on('change','.region',function (){
        var id_region = $('.region').val();
        document.getElementById('client').selectedIndex = 0;
        document.getElementById('departement').selectedIndex = 0;
        status = $('input[type=radio][name=status]:checked').attr('value');
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat.php",
            data: "id_region="+ id_region+"&status="+status, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    });
    
    Number.prototype.padLeft = function(base,chr){
        var  len = (String(base || 10).length - String(this).length)+1;
        return len > 0? new Array(len).join(chr || '0')+this : this;
    }

    $(document).on('click','.edit-cont',function(){
        // OK
        $("#contrat").modal("show");
        var contrat_id = this.id;
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat_id.php",
            data: "contrat_id="+ contrat_id, // on envoie $_GET['go']
            datatype: "json", // on veut un retour JSON
            success: function(data) {
                var list_contrat = JSON.parse(data);
                var datesign = new Date(list_contrat["signature"]);
                var datedem = new Date(list_contrat["demarrage"]);
                var datefin = new Date(list_contrat["date_fin_mission"]);
//                document.getElementById('jour').value = date.getDate().padLeft() + '/' + (date.getMonth() + 1).padLeft() + '/' + date.getFullYear();
                document.getElementById('num').value = list_contrat["numero"];
                document.getElementById('date_sign').value = datesign.getDate().padLeft() + '/' + (datesign.getMonth() + 1).padLeft() + '/' + datesign.getFullYear();
                document.getElementById('date_dem').value = datedem.getDate().padLeft() + '/' + (datedem.getMonth() + 1).padLeft() + '/' + datedem.getFullYear();
                document.getElementById('preavis').value = list_contrat["preavis"];
                document.getElementById('date_fin_mission').value = datefin.getDate().padLeft() + '/' + (datefin.getMonth() + 1).padLeft() + '/' + datefin.getFullYear();
                if (list_contrat["marche"] === "true"){
                    document.getElementById('marche').checked = true;
                }
                if (list_contrat["reconduction"] === "true"){
                    document.getElementById('tacite').checked = true;
                }
                document.getElementById('cli').value = list_contrat["id_client"];
                document.getElementById('base_sem').value = list_contrat["base_sem"];
                document.getElementById('vol').value = list_contrat["volume"];
                document.getElementById('nb_mois').value = list_contrat["nb_mois"];
                document.getElementById('desc').value = list_contrat["description"];
                document.getElementById('num_id_cont').value = list_contrat["id"];
                document.getElementById('date_fin_mission').value = list_contrat["date_fin_mission"];
                document.getElementById('bt_modif_cont').innerHTML = "Mettre à jour";
            }
        });
    });

    $(document).on('click','.view-cont',function(){
        // OK
        $("#contrat").modal("show");
        var contrat_id = this.id;
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat_id.php",
            data: "contrat_id="+ contrat_id, // on envoie $_GET['go']
            datatype: "json", // on veut un retour JSON
            success: function(data) {
                var list_contrat = JSON.parse(data);
                var datesign = new Date(list_contrat["signature"]);
                var datedem = new Date(list_contrat["demarrage"]);
                var datefin = new Date(list_contrat["date_fin_mission"]);
                document.getElementById('num').value = list_contrat["numero"];
                document.getElementById('date_sign').value = datesign.getDate().padLeft() + '/' + (datesign.getMonth() + 1).padLeft() + '/' + datesign.getFullYear();
                document.getElementById('date_dem').value = datedem.getDate().padLeft() + '/' + (datedem.getMonth() + 1).padLeft() + '/' + datedem.getFullYear();
                document.getElementById('preavis').value = list_contrat["preavis"];
                document.getElementById('marche').value = list_contrat["marche"];
                document.getElementById('tacite').value = list_contrat["reconduction"];
                document.getElementById('cli').value = list_contrat["id_client"];
                document.getElementById('date_fin_mission').value = datefin.getDate().padLeft() + '/' + (datefin.getMonth() + 1).padLeft() + '/' + datefin.getFullYear();
                document.getElementById('base_sem').value = list_contrat["base_sem"];
                document.getElementById('nb_mois').value = list_contrat["nb_mois"];
                document.getElementById('desc').value = list_contrat["description"];
                document.getElementById('vol').value = list_contrat["volume"];
                document.getElementById('num_id_cont').value = list_contrat["id"];
                document.getElementById('date_fin_mission').value = list_contrat["date_fin_mission"];
                document.getElementById('bt_modif_cont').innerHTML = "Imprimer";
                document.getElementById('num').disabled = true;
                document.getElementById('date_sign').disabled = true;
                document.getElementById('date_dem').disabled = true;
                document.getElementById('preavis').disabled = true;
                document.getElementById('marche').disabled = true;
                document.getElementById('tacite').disabled = true;
                document.getElementById('cli').disabled = true;
                document.getElementById('vol').disabled = true;
                document.getElementById('date_fin_mission').disabled = true;
                document.getElementById('base_sem').disabled = true;
                document.getElementById('nb_mois').disabled = true;
                document.getElementById('date_fin_mission').disabled = true;
                document.getElementById('desc').disabled = true;
            }
        });
    });

    $(document).on('click','.del-cont',function(){
        var contrat_id = this.id;
        $("#alert_contrat").modal("show");
        document.getElementById("text_suppr_contrat").innerHTML = "Etes-vous sur de vouloir supprimer le contrat n°"+contrat_id+"</b> de la liste des contrats ? <span><input style='opacity:0' id='id_cont_suppr' value='"+contrat_id+"'></input></span>";
    });

    $(document).on('click','#bt_modif_cont',function(){
        if (document.getElementById("bt_modif_cont").innerHTML === "Mettre à jour"){

            var num = $('#num').val();
            var date_sign = $('#date_sign').val();
            var date_dem = $('#date_dem').val();
            var preavis = $('#preavis').val();
            var marche = document.getElementById('marche').checked;
            var tacite = document.getElementById('tacite').checked;
            var id_cli = $('#cli').val();
            var base_sem = $('#base_sem').val();
            var nb_mois = $('#nb_mois').val();
            var desc = $('#desc').val();
            var vol = $('#vol').val();
            var id_contrat = document.getElementById('num_id_cont').value;
            var date_fin_mission = $('#date_fin_mission').val()
            $.post('forms/admin/contrat/modif_contrat.php',{id_contrat:id_contrat,num:num,date_sign:date_sign,vol:vol,date_dem:date_dem,preavis:preavis,marche:marche,
            tacite:tacite,id_cli:id_cli,base_sem:base_sem,nb_mois:nb_mois,desc:desc,date_fin_mission:date_fin_mission},function(data) {
                $("#contrat").modal("hide");
                $('#text_success_contrat').html(data);
                $("#success_contrat").modal("show");
            });
            setTimeout(function(){	
                $("#success_contrat").modal("hide");
                affich_contrat();
                RAZ_contrat();
            }, 2000);
            return false;
        }
        else if (document.getElementById("bt_modif_cont").innerHTML === "Imprimer") {
            RAZ_contrat();
        }
        else if (document.getElementById("bt_modif_cont").innerHTML === "Enregistrer") {
            var num = $('#num').val();
            var date_sign = $('#date_sign').val();
            var date_dem = $('#date_dem').val();
            var preavis = $('#preavis').val();
            var marche = document.getElementById('marche').checked;
            var tacite = document.getElementById('tacite').checked;
            var id_cli = $('#cli').val();
            var base_sem = $('#base_sem').val();
            var nb_mois = $('#nb_mois').val();
            var desc = $('#desc').val();
            var vol = $('#vol').val();
            var date_fin_mission = $('#date_fin_mission').val()
            var id_contrat = document.getElementById('num_id_cont').value;
            $.post('forms/admin/contrat/req_contrat_add.php',{id_contrat:id_contrat,num:num,date_sign:date_sign,vol:vol,date_dem:date_dem,preavis:preavis,marche:marche,
                tacite:tacite,id_cli:id_cli,base_sem:base_sem,nb_mois:nb_mois,desc:desc,date_fin_mission:date_fin_mission},function(data) {
                $("#contrat").modal("hide");
                $('#text_success_contrat').html(data);
                $("#success_contrat").modal("show");
            });
            setTimeout(function(){	
                $("#success_contrat").modal("hide");
                RAZ_contrat();
            }, 2000);
            affich_contrat();
            return false;
        }
    });

    $(document).on('click','#btn-add',function(){
        $("#contrat").modal("show");
    });

    $(document).on('click','.close',function(){
        RAZ_contrat();
    });

    $(document).on('click','#bt_annul_cont',function(){
        RAZ_contrat();
    });

    $(document).on('click','#bt_alert_suppr_contrat',function(){
        var id_contrat = document.getElementById('id_cont_suppr').value;
            $.ajax({
            type: "POST",
                url: "forms/admin/contrat/req_contrat_suppr.php",
                data: "id_contrat="+id_contrat, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                    $("#alert_contrat").modal("hide");
                    $('#text_success_contrat').html(data);
                    $("#success_contrat").modal("show");
                }
            });
            setTimeout(function(){  
                $("#success_contrat").modal("hide");
                affich_contrat();
            }, 2000);
            return false;
    });
    
    function affich_contrat(){
        var collab_id = myid;
        status = $('input[type=radio][name=status]:checked').attr('value');
        $.ajax({
            type: "POST",
            url: "forms/admin/contrat/req_gest_contrat.php",
            data: "collab_id="+ collab_id+"&status="+status, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
                secure_contrat();
            }
        });
    }
    
    function RAZ_contrat(){
        document.getElementById('num').value = "";
        document.getElementById('date_sign').value = "";
        document.getElementById('vol').value = "";
        document.getElementById('date_dem').value = "";
        document.getElementById('preavis').value = "";
        document.getElementById('marche').checked = false;
        document.getElementById('tacite').checked = false;
        document.getElementById('cli').value = "";
        document.getElementById('date_fin_mission').value = "";
        document.getElementById('base_sem').value = "";
        document.getElementById('nb_mois').value = "";
        document.getElementById('desc').value = "";
        document.getElementById('date_fin_mission').value = '';
        document.getElementById('bt_modif_cont').value = "Enregistrer";
        document.getElementById('num').disabled = false;
        document.getElementById('date_sign').disabled = false;
        document.getElementById('vol').disabled = false;
        document.getElementById('date_dem').disabled = false;
        document.getElementById('preavis').disabled = false;
        document.getElementById('marche').disabled = false;
        document.getElementById('tacite').disabled = false;
        document.getElementById('cli').disabled = false;
        document.getElementById('date_fin_mission').disabled = false;
        document.getElementById('base_sem').disabled = false;
        document.getElementById('nb_mois').disabled = false;
        document.getElementById('desc').disabled = false;
        document.getElementById('date_fin_mission').disabled = false;
    }
});