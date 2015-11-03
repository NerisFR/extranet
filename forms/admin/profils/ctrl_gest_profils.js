$(function() {

    affich_profils();
        
    $(document).on('click','.edit_pro',function (){
        id_profil = this.id;
        document.getElementById('pro'+id_profil).disabled=false;
        document.getElementById('nds'+id_profil).disabled=false;
        document.getElementById('tdbh'+id_profil).disabled=false;
        document.getElementById('tdbt'+id_profil).disabled=false;
        document.getElementById('gclient'+id_profil).disabled=false;
        document.getElementById('gcollab'+id_profil).disabled=false;
        document.getElementById('gcontrat'+id_profil).disabled=false;
        document.getElementById('gaffect'+id_profil).disabled=false;
        document.getElementById('gprofils'+id_profil).disabled=false;
        document.getElementById('save_pro_'+id_profil).style.opacity = 1;
        document.getElementById('save_pro_'+id_profil).style.cursor = 'pointer';
    });
        
    $(document).on('click','.del-pro',function (){
        $("#alert_profils").modal("show");
        var profil_id = this.id;
        document.getElementById('id_profils_suppr').value = profil_id;
        document.getElementById("text_suppr_profils").innerHTML = "Etes-vous sur de vouloir supprimer le profil n°"+profil_id;
    });

    $(document).on('click','.save_pro',function(){
            prof = this.id;
            var elem = prof.split('_');
            id_profil = elem[2];
            pro = $('#pro'+id_profil).val();
            nds = $('#nds'+id_profil).val();
            tdbh = $('#tdbh'+id_profil).val();
            tdbt = $('#tdbt'+id_profil).val();
            gclient = $('#gclient'+id_profil).val();
            gcollab = $('#gcollab'+id_profil).val();
            gcontrat = $('#gcontrat'+id_profil).val();
            gaffect = $('#gaffect'+id_profil).val();
            gprofils = $('#gprofils'+id_profil).val();
            $.post('forms/admin/profils/req_gest_profils_modif.php',{id_profil:id_profil,pro:pro,nds:nds,tdbh:tdbh,tdbt:tdbt,gclient:gclient,gcollab:gcollab,gcontrat:gcontrat,gaffect:gaffect,gprofils:gprofils},function(data) {
                    $('#text_success_profils').html(data);
                    $("#success_profils").modal("show");
                });
                // setTimeout(function(){	
                //     $("#success_profils").modal("hide");
                // }, 2000);
            affich_profils();   
            return false;
        });
        
    $(document).on('click','.new_save_pro',function(){
        pro = $('#new_profil').val();
        nds = $('#new_nds').val();
        tdbh = $('#new_tdbh').val();
        tdbt = $('#new_tdbt').val();
        gclient = $('#new_gclient').val();
        gcollab = $('#new_gcollab').val();
        gcontrat = $('#new_gcontrat').val();
        gaffect = $('#new_gaffect').val();
        gprofils = $('#new_gprofils').val();
        $.post('forms/admin/profils/req_gest_profils_add.php',{pro:pro,nds:nds,tdbh:tdbh,tdbt:tdbt,gclient:gclient,gcollab:gcollab,gcontrat:gcontrat,gaffect:gaffect,gprofils:gprofils},function(data) {
                $('#text_success_profils').html(data);
                $("#success_profils").modal("show");
            });
            setTimeout(function(){  
                $("#success_profils").modal("hide");
            }, 2000);
        affich_profils();  
        return false;
    });

       
    $(document).on('click','#bt_alert_suppr_profils',function(){
        var profil_id = document.getElementById('id_profils_suppr').value;
        $.ajax({
    	type: "POST",
            url: "forms/admin/profils/req_profils_del.php",
            data: "profil_id="+profil_id, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $("#alert_profils").modal("hide");
                $('#text_success_profils').html(data);
                $("#success_profils").modal("show");
            }
        });
        setTimeout(function(){	
            $("#success_profils").modal("hide");
            affich_profils();
        }, 2000);
        
        return false;
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

    function affich_profils(){
        var id_collab = $('#collab').val();
        $.ajax({
    	type: "POST",
            url: "forms/admin/profils/req_gest_profils.php",
            data: "id_collab="+id_collab, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    }
    
});