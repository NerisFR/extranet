$(document).ready(function(){
	
    Affich_NDS();
    
    $(document).on('change','.collab',function (){
        document.getElementById('client').length=0;
        var collab_id = $('.collab').val();
        var list_client;
        $.ajax({
            type: "POST",
                url: "forms/nds/consult/req_cli.php",
                data: "collab_id="+ collab_id, // on envoie $_GET['go']
                datatype: "json", // on veut un retour JSON
                success: function(data) {
                    $('.client').empty();
                    var list_client = $.parseJSON(data);
                    nb = 0;
                    $('.client').append('<option value="0"></option>');
                    $.each($.parseJSON(data), function(index, value) {
                    $('.client').append('<option value="'+ list_client[nb].index +'">'+ list_client[nb].value +'</option>');
                    nb++;
                    });
                }
        });
    });

    $(document).on('change','.client',function (){
        var collab_id = $('.collab').val();
        var client_id = $('.client').val();
        // var list_contrat


        $.ajax({
        	type: "POST",
			url: "forms/nds/consult/req_contrats.php",
			data: "collab_id="+ collab_id+"&client_id="+client_id, // on envoie $_GET['go']
			datatype: "json", // on veut un retour JSON
			success: function(data) {
				$('.contrat').empty();
				$('.contrat').append('<option value=""></option>');
				var list_contrat = $.parseJSON(data);
				nb = 0;
				$.each($.parseJSON(data), function(index, value) {
				$('.contrat').append('<option value="'+ list_contrat[nb].index +'">'+ list_contrat[nb].value +'</option>');
				nb++;
				});
			}
        });
    });

    $(document).on('change','.collab_consult',function (){
    	$('.client_consult').empty();
        var collab_id = $('.collab_consult').val();
        $.ajax({
        	type: "POST",
			url: "forms/nds/consult/req_cli.php",
			data: "collab_id="+ collab_id, // on envoie $_GET['go']
			datatype: "json", // on veut un retour JSON
			success: function(data) {
				$('.client_consult').empty();
				var list_client = $.parseJSON(data);
				nb = 0;
				$('.client_consult').append('<option value="0"></option>');
				$.each($.parseJSON(data), function(index, value) {
				$('.client_consult').append('<option value="'+ list_client[nb].index +'">'+ list_client[nb].value +'</option>');

				
				nb++;
				});
			}
        });
    });

    $(document).on('change','.client_consult',function (){
    	$('.contrat_consult').empty();
        var collab_id = $('.collab_consult').val();
        var client_id = $('.client_consult').val();
        $.ajax({
        	type: "POST",
			url: "forms/nds/consult/req_contrats.php",
			data: "collab_id="+ collab_id+"&client_id="+client_id, // on envoie $_GET['go']
			datatype: "json", // on veut un retour JSON
			success: function(data) {
				$('.contrat_consult').empty();
				$('.contrat_consult').empty();
				$('.contrat_consult').append('<option value="0"></option>');
				var list_contrat = $.parseJSON(data);
				nb = 0;
				$.each($.parseJSON(data), function(index, value) {
				$('.contrat_consult').append('<option value="'+ list_contrat[nb].index +'">'+ list_contrat[nb].value +'</option>');

				nb++;
				});
			}
        });
    });

    $('#bt_affich_consult').on('click',function (){
        var collab_id = $('.collab_consult').val();
        var client_id = $('.client_consult').val();
        var contrat_id = $('.contrat_consult').val();
        var date_debut = $('.date_debut').val();
        var date_fin = $('.date_fin').val();
        var type_heure = $('.type_heure_consult').val();
        $.ajax({
            type: "POST",
                url: "forms/nds/consult/req_NDS.php",
                data: "collab_id="+ collab_id+"&client_id="+client_id+"&contrat_id="+contrat_id+"&date_debut="+date_debut+"&date_fin="+date_fin+"&type_heure="+type_heure, // on envoie $_GET['go']
                datatype: "html", // Affichage de la page HTML
                success: function(data) {
                    $('.afficher').html(data);
                }
        });
        secure_nds();
    });
    
    Number.prototype.padLeft = function(base,chr){
        var  len = (String(base || 10).length - String(this).length)+1;
        return len > 0? new Array(len).join(chr || '0')+this : this;
        }

    $(document).on('dblclick','#listNDS tr',function (){
        var nds_id = this.id;
        $.ajax({
        type: "POST",
            url: "forms/nds/consult/req_consult_NDS_id.php",
            data: "nds_id="+ nds_id,
            datatype: "json", // on veut un retour JSON
            success: function(data) {
                var list_NDS = JSON.parse(data);
                document.getElementById('collab').value = list_NDS["collab_id"];
                document.getElementById('client').value = list_NDS["client_id"];
                var collab_id = list_NDS["collab_id"];;
                var client_id = list_NDS["client_id"];
                var list_contrat
                $.ajax({
                    type: "POST",
                    url: "forms/nds/consult/req_contrats.php",
                    data: "collab_id="+ collab_id+"&client_id="+client_id, // on envoie $_GET['go']
                    datatype: "json", // on veut un retour JSON
                    success: function(data) {
                        $('.contrat').empty();
                        $('.contrat').append('<option value="0"></option>');
                        var list_contrat = $.parseJSON(data);
                        nbs = 0;
                        $.each($.parseJSON(data), function(index, value) {
                            if (list_contrat[nbs].index == list_NDS["contrat_id"]){
                                $('.contrat').append('<option selected value="'+ list_contrat[nbs].index +'">'+ list_contrat[nbs].value +'</option>');
                            }
                            else {
                                $('.contrat').append('<option value="'+ list_contrat[nbs].index +'">'+ list_contrat[nbs].value +'</option>');
                            }
                        nbs++;
                        });
                    }
                });
            document.getElementById('type_heure').value = list_NDS["type_heure"];
            var date = new Date(list_NDS["jour"]);
            document.getElementById('jour').value = date.getDate().padLeft() + '/' + (date.getMonth() + 1).padLeft() + '/' + date.getFullYear();
            document.getElementById('h_debut').value = list_NDS["arrivee"];
            document.getElementById('h_fin').value = list_NDS["depart"];
            document.getElementById('TPS_ADM').value = list_NDS["tps_adm"];
            document.getElementById('TPS_PROJ').value = list_NDS["tps_proj"];
            document.getElementById('TPS_MAINT').value = list_NDS["tps_maint"];
            document.getElementById('TPS_DEV').value = list_NDS["tps_dev"];
            document.getElementById('TPS_PARC').value = list_NDS["tps_parc"];
            document.getElementById('TPS_REUNION').value = list_NDS["tps_reunion"];
            document.getElementById('TPS_PRIX').value = list_NDS["tps_prix"];
            document.getElementById('TPS_DEP').value = list_NDS["tps_dep"];
            document.getElementById('TPS_INST').value = list_NDS["tps_inst"];
            document.getElementById('TPS_CTRL').value = list_NDS["tps_ctrl"];
            document.getElementById('TPS_ASSIST').value = list_NDS["tps_assist"];
            document.getElementById('TPS_AUTRE').value = list_NDS["tps_autre"];
            document.getElementById('TPS_FORM').value = list_NDS["tps_form"];
            document.getElementById('CTRL_LOG').checked = list_NDS["ctrl_log"];
            document.getElementById('CTRL_MAJ_OS').checked = list_NDS["ctrl_maj_os"];
            document.getElementById('CTRL_HDD').checked = list_NDS["ctrl_hdd"];
            document.getElementById('CTRL_MAJ_HARD').checked = list_NDS["ctrl_maj_hard"];
            document.getElementById('CTRL_RAID').checked = list_NDS["ctrl_raid"];
            document.getElementById('CTRL_MAJ_SOFT').checked = list_NDS["ctrl_maj_soft"];
            document.getElementById('CTRL_BACKUP').checked = list_NDS["ctrl_backup"];
            document.getElementById('CTRL_ANTIVIRUS').checked = list_NDS["ctrl_antivirus"];
            document.getElementById('VOLUM_BACKUP').checked = list_NDS["volum_backup"];
            document.getElementById('MAJ_ANTIVIRUS').checked = list_NDS["maj_antivirus"];
            document.getElementById('MAJ_BACKUP').checked = list_NDS["maj_backup"];
            document.getElementById('comment').value = list_NDS["commentaire"];
            document.getElementById("bt_modif").innerHTML = "Mettre à jour";
            document.getElementById("bt_impr").style.opacity = 1;
            document.getElementById('num_id').value = list_NDS["id"];
            if(mynds=="a"){
                document.getElementById('bt_del').style.opacity = 1;
            }
            }
        });
        $("#saisie").modal("show");
    });

    $("#bt_impr").on('click',function(){
        var nds_id = document.getElementById('num_id').value;
        window.open("forms/nds/consult/print_nds.php?nds_id="+nds_id);
        setTimeout(function(){
            $("#saisie").modal("hide");
            RAZ_saisie();
        }, 1500);
        return false;
    });

    $('#btn-add').on('click',function(){
        var maintenant=new Date();
        document.getElementById('h_debut').value = "09:00";
        document.getElementById('h_fin').value = "17:00";
        $("#saisie").modal("show");
        $("#bt_modif").innerHTML = "Enregistrer";
        document.getElementById("bt_impr").style.opacity = 0;

        });

    $(document).on('click','.close',function(){
        document.getElementById('collab').value = myid;
        RAZ_saisie();
    });

    //detection si enregistre ou mettre a jour
    $(document).on('click','#bt_modif',function (){
        if (document.getElementById("bt_modif").innerHTML == "Enregistrer"){
            var collab_id = $('.collab').val();
            var client_id = $('.client').val();
            var contrat_id = $('.contrat').val();
            var type_heure = $('.type_heure').val();
            var jour = $('#jour').val();
            var h_debut = $('.h_debut').val();
            var h_fin = $('.h_fin').val();
            var TPS_ADM = $('.TPS_ADM').val();
            var TPS_PROJ = $('.TPS_PROJ').val();
            var TPS_MAINT = $('.TPS_MAINT').val();
            var TPS_DEV = $('.TPS_DEV').val();
            var TPS_PARC = $('.TPS_PARC').val();
            var TPS_REUNION = $('.TPS_REUNION').val();
            var TPS_PRIX = $('.TPS_PRIX').val();
            var TPS_DEP = $('.TPS_DEP').val();
            var TPS_INST = $('.TPS_INST').val();
            var TPS_CTRL = $('.TPS_CTRL').val();
            var TPS_ASSIST = $('.TPS_ASSIST').val();
            var TPS_AUTRE = $('.TPS_AUTRE').val();
            var TPS_FORM = $('.TPS_FORM').val();
            if($('.CTRL_LOG').is(":checked")){
                var CTRL_LOG = 'true';
            }
            else{
                var CTRL_LOG = 'false';
            }
            if($('.CTRL_MAJ_OS').is(":checked")){
                var CTRL_MAJ_OS = 'true';
            }
            else{
                var CTRL_MAJ_OS = 'false';
            }
            if($('.CTRL_HDD').is(":checked")){
                var CTRL_HDD = 'true';
            }
            else{
                var CTRL_HDD = 'false';
            }
            if($('.CTRL_MAJ_HARD').is(":checked")){
                var CTRL_MAJ_HARD = 'true';
            }
            else{
                var CTRL_MAJ_HARD = 'false';
            }
            if($('.CTRL_RAID').is(":checked")){
                var CTRL_RAID = 'true';
            }
            else{
                var CTRL_RAID = 'false';
            }
            if($('.CTRL_MAJ_SOFT').is(":checked")){
                var CTRL_MAJ_SOFT = 'true';
            }
            else{
                var CTRL_MAJ_SOFT = 'false';
            }
            if($('.CTRL_BACKUP').is(":checked")){
                var CTRL_BACKUP = 'true';
            }
            else{
                var CTRL_BACKUP = 'false';
            }
            if($('.CTRL_ANTIVIRUS').is(":checked")){
                var CTRL_ANTIVIRUS = 'true';
            }
            else{
                var CTRL_ANTIVIRUS = 'false';
            }
            if($('.VOLUM_BACKUP').is(":checked")){
                var VOLUM_BACKUP = 'true';
            }
            else{
                var VOLUM_BACKUP = 'false';
            }
            if($('.MAJ_ANTIVIRUS').is(":checked")){
                var MAJ_ANTIVIRUS = 'true';
            }
            else{
                var MAJ_ANTIVIRUS = 'false';
            }
            if($('.MAJ_BACKUP').is(":checked")){
                var MAJ_BACKUP = 'true';
            }
            else{
                var MAJ_BACKUP = 'false';
            }
            var TPS_TOTAL = TPS_ADM+TPS_PROJ+TPS_MAINT+TPS_DEV+TPS_PARC+TPS_REUNION+TPS_PRIX+TPS_DEP+TPS_INST+TPS_CTRL+TPS_ASSIST+TPS_AUTRE+TPS_FORM;
            if (TPS_TOTAL <= 0){
                document.getElementById("reussi").style.backgroundColor='#e6585f';
                $('.reussi').html('Veuillez renseigner votre temps de travail dans au moins une des taches!!!').slideDown(1000);
                return;
            }
            var comment = document.getElementById('comment').value;
            $.post('forms/nds/req_saisie.php',{collab_id:collab_id,client_id:client_id,contrat_id:contrat_id,type_heure:type_heure,jour:jour,h_debut:h_debut,h_fin:h_fin,TPS_ADM:TPS_ADM,TPS_PROJ:TPS_PROJ,
                TPS_MAINT:TPS_MAINT,TPS_DEV:TPS_DEV,TPS_PARC:TPS_PARC,TPS_REUNION:TPS_REUNION,TPS_PRIX:TPS_PRIX,TPS_DEP:TPS_DEP,TPS_INST:TPS_INST,TPS_CTRL:TPS_CTRL,TPS_ASSIST:TPS_ASSIST,TPS_AUTRE:TPS_AUTRE,
                TPS_FORM:TPS_FORM,CTRL_LOG:CTRL_LOG,CTRL_MAJ_OS:CTRL_MAJ_OS,CTRL_HDD:CTRL_HDD,CTRL_MAJ_HARD:CTRL_MAJ_HARD,CTRL_RAID:CTRL_RAID,CTRL_MAJ_SOFT:CTRL_MAJ_SOFT,CTRL_BACKUP:CTRL_BACKUP,CTRL_ANTIVIRUS:CTRL_ANTIVIRUS,
                VOLUM_BACKUP:VOLUM_BACKUP,MAJ_ANTIVIRUS:MAJ_ANTIVIRUS,MAJ_BACKUP:MAJ_BACKUP,comment:comment},function(data) {
                    $("#saisie").modal("hide");
                    $('#text_success').html(data);
                    $("#success").modal("show");
                });
            setTimeout(function(){
                RAZ_saisie();
                $("#success").modal("hide");
                Affich_NDS();
            }, 1500);

            return false;
       
    }
        else if (document.getElementById("bt_modif").innerHTML == "Mettre à jour") {
            var collab_id = $('.collab').val();
            var client_id = $('.client').val();
            var contrat_id = $('.contrat').val();
            var type_heure = $('.type_heure').val();
            var jour = $('#jour').val();
            var h_debut = $('.h_debut').val();
            var h_fin = $('.h_fin').val();
            var TPS_ADM = $('.TPS_ADM').val();
            var TPS_PROJ = $('.TPS_PROJ').val();
            var TPS_MAINT = $('.TPS_MAINT').val();
            var TPS_DEV = $('.TPS_DEV').val();
            var TPS_PARC = $('.TPS_PARC').val();
            var TPS_REUNION = $('.TPS_REUNION').val();
            var TPS_PRIX = $('.TPS_PRIX').val();
            var TPS_DEP = $('.TPS_DEP').val();
            var TPS_INST = $('.TPS_INST').val();
            var TPS_CTRL = $('.TPS_CTRL').val();
            var TPS_ASSIST = $('.TPS_ASSIST').val();
            var TPS_AUTRE = $('.TPS_AUTRE').val();
            var TPS_FORM = $('.TPS_FORM').val();
            if($('.CTRL_LOG').is(":checked")){
                var CTRL_LOG = 'true';
            }
            else{
                var CTRL_LOG = 'false';
            }
            if($('.CTRL_MAJ_OS').is(":checked")){
                var CTRL_MAJ_OS = 'true';
            }
            else{
                var CTRL_MAJ_OS = 'false';
            }
            if($('.CTRL_HDD').is(":checked")){
                var CTRL_HDD = 'true';
            }
            else{
                var CTRL_HDD = 'false';
            }
            if($('.CTRL_MAJ_HARD').is(":checked")){
                var CTRL_MAJ_HARD = 'true';
            }
            else{
                var CTRL_MAJ_HARD = 'false';
            }
            if($('.CTRL_RAID').is(":checked")){
                var CTRL_RAID = 'true';
            }
            else{
                var CTRL_RAID = 'false';
            }
            if($('.CTRL_MAJ_SOFT').is(":checked")){
                var CTRL_MAJ_SOFT = 'true';
            }
            else{
                var CTRL_MAJ_SOFT = 'false';
            }
            if($('.CTRL_BACKUP').is(":checked")){
                var CTRL_BACKUP = 'true';
            }
            else{
                var CTRL_BACKUP = 'false';
            }
            if($('.CTRL_ANTIVIRUS').is(":checked")){
                var CTRL_ANTIVIRUS = 'true';
            }
            else{
                var CTRL_ANTIVIRUS = 'false';
            }
            if($('.VOLUM_BACKUP').is(":checked")){
                var VOLUM_BACKUP = 'true';
            }
            else{
                var VOLUM_BACKUP = 'false';
            }
            if($('.MAJ_ANTIVIRUS').is(":checked")){
                var MAJ_ANTIVIRUS = 'true';
            }
            else{
                var MAJ_ANTIVIRUS = 'false';
            }
            if($('.MAJ_BACKUP').is(":checked")){
                var MAJ_BACKUP = 'true';
            }
            else{
                var MAJ_BACKUP = 'false';
            }
            var comment = document.getElementById('comment').value;
            var nds_id = document.getElementById('num_id').value;
            $.post('forms/nds/req_saisie_modif.php',{nds_id:nds_id,collab_id:collab_id,client_id:client_id,contrat_id:contrat_id,type_heure:type_heure,jour:jour,h_debut:h_debut,h_fin:h_fin,TPS_ADM:TPS_ADM,TPS_PROJ:TPS_PROJ,
                TPS_MAINT:TPS_MAINT,TPS_DEV:TPS_DEV,TPS_PARC:TPS_PARC,TPS_REUNION:TPS_REUNION,TPS_PRIX:TPS_PRIX,TPS_DEP:TPS_DEP,TPS_INST:TPS_INST,TPS_CTRL:TPS_CTRL,TPS_ASSIST:TPS_ASSIST,TPS_AUTRE:TPS_AUTRE,
                TPS_FORM:TPS_FORM,CTRL_LOG:CTRL_LOG,CTRL_MAJ_OS:CTRL_MAJ_OS,CTRL_HDD:CTRL_HDD,CTRL_MAJ_HARD:CTRL_MAJ_HARD,CTRL_RAID:CTRL_RAID,CTRL_MAJ_SOFT:CTRL_MAJ_SOFT,CTRL_BACKUP:CTRL_BACKUP,CTRL_ANTIVIRUS:CTRL_ANTIVIRUS,
                VOLUM_BACKUP:VOLUM_BACKUP,MAJ_ANTIVIRUS:MAJ_ANTIVIRUS,MAJ_BACKUP:MAJ_BACKUP,comment:comment},function(data) {
                    $('#text_success').html(data);
                    $("#saisie").modal("hide");
                    $("#success").modal("show");
                });
            setTimeout(function(){
                RAZ_saisie();
                $("#success").modal("hide");
                Affich_NDS();
            }, 1500);
            return false;
        }
    });

    $(document).on('click','#bt_del',function (){
        var nds_id = document.getElementById('num_id').value;
        $("#saisie").modal("hide");
        $("#alert").modal("show");
        document.getElementById('id_suppr').value=nds_id;
        document.getElementById("text_suppr").firstChild.data = "Etes-vous sur de vouloir supprimer la note de synthese n°"+nds_id;
        return false;
    });

    $(document).on('click','#bt_alert_suppr',function (){
        var nds_id = $('#id_suppr').val();
        $.ajax({
            type: "POST",
                url: "forms/nds/consult/req_saisie_suppr.php",
                data: "nds_id="+nds_id, // on envoie $_GET['go']
                datatype: "html", // on veut un retour JSON
                success: function(data) {
                        document.getElementById("text_success").html(data);
                }
        });
        $("#alert").modal("hide");
        $("#success").modal("show");
        document.getElementById("text_success").firstChild.data = "La note de synthese n°"+nds_id+" a bien été supprimée.";
        setTimeout(function(){
            $("#success").modal("hide");
            Affich_NDS();
        }, 1500);
        return false;
    });
    
    $(document).on('click','#bt_annul',function (){
        RAZ_saisie();
    });

    function RAZ_saisie () {
        document.getElementById('client').value = 0;
        document.getElementById('contrat').length =0;
        document.getElementById('type_heure').value = "Normale";
        document.getElementById('jour').value = "";
        document.getElementById('h_debut').value = "";
        document.getElementById('h_fin').value = "";
        document.getElementById('TPS_ADM').value = "";
        document.getElementById('TPS_PROJ').value = "";
        document.getElementById('TPS_MAINT').value = "";
        document.getElementById('TPS_DEV').value = "";
        document.getElementById('TPS_PARC').value = "";
        document.getElementById('TPS_REUNION').value = "";
        document.getElementById('TPS_PRIX').value = "";
        document.getElementById('TPS_DEP').value = "";
        document.getElementById('TPS_INST').value = "";
        document.getElementById('TPS_CTRL').value = "";
        document.getElementById('TPS_ASSIST').value = "";
        document.getElementById('TPS_AUTRE').value = "";
        document.getElementById('TPS_FORM').value = "";
        document.getElementById('CTRL_LOG').checked = false;
        document.getElementById('CTRL_MAJ_OS').checked = false;
        document.getElementById('CTRL_HDD').checked = false;
        document.getElementById('CTRL_MAJ_HARD').checked = false;
        document.getElementById('CTRL_RAID').checked = false;
        document.getElementById('CTRL_MAJ_SOFT').checked = false;
        document.getElementById('CTRL_BACKUP').checked = false;
        document.getElementById('CTRL_ANTIVIRUS').checked = false;
        document.getElementById('VOLUM_BACKUP').checked = false;
        document.getElementById('MAJ_ANTIVIRUS').checked = false;
        document.getElementById('MAJ_BACKUP').checked = false;
        document.getElementById('comment').value = "";
        document.getElementById('collab').disabled = false;
        document.getElementById('client').disabled = false;
        document.getElementById('contrat').disabled = false;
        document.getElementById('type_heure').disabled = false;
        document.getElementById('jour').disabled = false;
        document.getElementById('h_debut').disabled = false;
        document.getElementById('h_fin').disabled = false;
        document.getElementById('TPS_ADM').disabled = false;
        document.getElementById('TPS_PROJ').disabled = false;
        document.getElementById('TPS_MAINT').disabled = false;
        document.getElementById('TPS_DEV').disabled = false;
        document.getElementById('TPS_PARC').disabled = false;
        document.getElementById('TPS_REUNION').disabled = false;
        document.getElementById('TPS_PRIX').disabled = false;
        document.getElementById('TPS_DEP').disabled = false;
        document.getElementById('TPS_INST').disabled = false;
        document.getElementById('TPS_CTRL').disabled = false;
        document.getElementById('TPS_ASSIST').disabled = false;
        document.getElementById('TPS_AUTRE').disabled = false;
        document.getElementById('TPS_FORM').disabled = false;
        document.getElementById('CTRL_LOG').disabled = false;
        document.getElementById('CTRL_MAJ_OS').disabled = false;
        document.getElementById('CTRL_HDD').disabled = false;
        document.getElementById('CTRL_MAJ_HARD').disabled = false;
        document.getElementById('CTRL_RAID').disabled = false;
        document.getElementById('CTRL_MAJ_SOFT').disabled = false;
        document.getElementById('CTRL_BACKUP').disabled = false;
        document.getElementById('CTRL_ANTIVIRUS').disabled = false;
        document.getElementById('VOLUM_BACKUP').disabled = false;
        document.getElementById('MAJ_ANTIVIRUS').disabled = false;
        document.getElementById('MAJ_BACKUP').disabled = false;
        document.getElementById('comment').disabled = false;
        document.getElementById("bt_impr").style.opacity = 1;
        document.getElementById("bt_modif").innerHTML = "Enregistrer";
    };
    
    function Affich_NDS(){
        var collab_id = $('.collab_consult').val();
        var client_id = $('.client_consult').val();
        var contrat_id = $('.contrat_consult').val();
        var date_debut = $('.date_debut').val();
        var date_fin = $('.date_fin').val();
        var type_heure = $('.type_heure_consult').val();
        $.ajax({
            type: "POST",
                url: "forms/nds/consult/req_NDS.php",
                data: "collab_id="+ collab_id+"&client_id="+client_id+"&contrat_id="+contrat_id+"&date_debut="+date_debut+"&date_fin="+date_fin+"&type_heure="+type_heure, // on envoie $_GET['go']
                datatype: "html", // Affichage de la page HTML
                success: function(data) {
                    $('.afficher').html(data);
                }
            });  
        
        secure_nds();
    };
});

