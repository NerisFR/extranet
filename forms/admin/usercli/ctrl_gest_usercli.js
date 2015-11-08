$(function() {

	$('document').ready(function(){
            affich_user_client();
 	});
    
    

    $(document).on('dblclick','#list_usercli tr',function (){
        id_usercli = this.id;
        var arrayColonnes;
        var arrayColonnes = this.cells;
        nom = arrayColonnes[0].innerHTML;
        prenom = arrayColonnes[1].innerHTML;
        fonction = arrayColonnes[2].innerHTML;
        loggin = arrayColonnes[3].innerHTML;
        arrayColonnes.item(0).innerHTML = "<input name='nom_usercli_new' class='form-control nom_usercli_new' id='nom_usercli_new' value='"+nom+"'></input>";
        arrayColonnes.item(1).innerHTML = "<input name='prenom_usercli_new' class='form-control prenom_usercli_new' id='prenom_usercli_new' value='"+prenom+"'></input>";
        arrayColonnes.item(2).innerHTML = "<input name='fonction_usercli_new' class='form-control fonction_usercli_new' id='fonction_usercli_new' value='"+fonction+"'></input>";
        arrayColonnes.item(3).innerHTML = "<input name='loggin_usercli_new' class='form-control loggin_usercli_new' id='loggin_usercli_new' value='"+loggin+"'></input>";
        arrayColonnes.item(5).innerHTML = "<font size='4pt'><i style='cursor:pointer;color:#00a65a;opacity:1' class='glyphicon glyphicon-ok save_affect_collab'></i></font>";
        $('html').click(function()
        {
            arrayColonnes.item(0).innerHTML = nom;
            arrayColonnes.item(1).innerHTML = prenom;
            arrayColonnes.item(2).innerHTML = fonction;
            arrayColonnes.item(3).innerHTML = loggin;
            arrayColonnes.item(5).innerHTML = "";
        });
        $('#list_usercli tr').click(function(event)
        {
           event.stopPropagation();
        });
        
    });

	$(document).on('click','.save_usercli',function(){
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
            affich_users_client();
            return false;
        });
        
    $(document).on('click','.save_new_usercli',function(){
        nom_usercli = document.getElementById("nom_usercli_new").value;
        prenom_usercli = document.getElementById("prenom_usercli_new").value;
        fonction_usercli = document.getElementById("fonction_usercli_new").value;
        loggin_usercli = document.getElementById("loggin_usercli_new").value; 
        password_usercli = document.getElementById("password_usercli_new").value; 
        $.post('forms/admin/usercli/req_gest_usercli_add.php',{nom_usercli:nom_usercli,prenom_usercli:prenom_usercli,fonction_usercli:fonction_usercli,loggin_usercli:loggin_usercli,password_usercli:password_usercli,myid:myid},function(data) {
                $('#text_success_usercli').html(data);
                $("#success_usercli").modal("show");
            });
            setTimeout(function(){  
                $("#success_usercli").modal("hide");
            }, 2000);
        affich_user_client();
        return false;
    });    
             
    $(document).on('click','.del-usercli',function (){
        $("#alert_usercli").modal("show");
        var usercli_id = this.id;
        document.getElementById('id_usercli_suppr').value = usercli_id;
        document.getElementById("text_suppr_usercli").innerHTML = "Etes-vous sur de vouloir supprimer l'utilisateur n°"+usercli_id;
    });
               
    $(document).on('click','#bt_alert_suppr_usercli',function(){
        var usercli_id = document.getElementById('id_usercli_suppr').value;
        $.ajax({
    	type: "POST",
            url: "forms/admin/usercli/req_usercli_del.php",
            data: "usercli_id="+usercli_id, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $("#alert_usercli").modal("hide");
                $('#text_success_usercli').html(data);
                $("#success_usercli").modal("show");
            }
        });
        setTimeout(function(){	
            $("#success_usercli").modal("hide");
        }, 2000);
        affich_user_client();
        return false;
 	});


    function affich_user_client(){
        $.ajax({
    	type: "POST",
            url: "forms/admin/usercli/req_gest_usercli.php",
            data: "myid_client="+myid_client+"&myid="+myid, // on envoie $_GET['go']
            datatype: "html", // on veut un retour JSON
            success: function(data) {
                $('.afficher').html(data);
            }
        });
    }
        
        
    
});