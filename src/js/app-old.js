$(function() {

    $(document).ready(function(){
//        nb = 0;
//        if(myclient === 'n'){
//            document.getElementById('myclient').style.display = "none";
//            nb++;
//        } 
//        if(mycollab === 'n'){
//            document.getElementById('mycollab').style.display = "none";
//            nb++;
//        }
//        if(mycontrat === 'n'){
//            document.getElementById('mycontrat').style.display = "none";
//            nb++;
//        }
//        if(myaffect == 'n'){
//            document.getElementById('myaffect').style.display = "none";
//            nb++;
//        }
//        if(nb == 4){
//            document.getElementById('myadmin').style.display = "none";
//        }    
    })
    
    $(".subcontent").click(function (){
        page=$(this).attr("href");
        $('.treeview').collapse('hide');
        $.ajax({
            url : "forms/"+page,
            cache : false,
            success : function(html){
                afficher(html);
                
            },
            error : function(XMLHttpRequest, textStatus, errorThrown){
                alert(textStatus);
            }
        
        })
        return false;
    })
});

function afficher(html){
    $("#content").fadeOut(250,function(){
        $("#content").empty();
        $("#content").append(html);
        $("#content").fadeIn(500);
    })
};

//function secure_nds(){
//    if (mynds=="w"){
//        document.getElementById('collab_consult').disabled = 'false';
//        document.getElementById('collab').disabled = 'false';
//    }
//    if (mynds=="r"){
//        document.getElementById('ajout-nds').style.display = 'none';
//        $('.edit-nds').style.display = 'none';
//        $('.del-nds').style.display = 'none';
//    }
//};