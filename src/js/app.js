$(function() {

    $(document).ready(function(){
        nb = 0;
        if(myclient === 'n'){
            document.getElementById('myclient').style.display = "none";
            nb++;
        } 
        if(mycollab === 'n'){
            document.getElementById('mycollab').style.display = "none";
            nb++;
        }
        if(mycontrat === 'n'){
            document.getElementById('mycontrat').style.display = "none";
            nb++;
        }
        if(myaffect == 'n'){
            document.getElementById('myaffect').style.display = "none";
            nb++;
        }
        if(mygprofil == 'n'){
            document.getElementById('myprofils').style.display = "none";
            nb++;
        }
        if(nb == 5){
            document.getElementById('myadmin').style.display = "none";
        }  
    })



    $(".subcontent").click(function (){
        page=$(this).attr("href");
//        alert("test");
        $.ajax({
            url : "forms/"+page,
            cache : false,
            success : function(html){
                afficher(html);
                $('#nav').toggleClass('hide');
                $('#nav').toggleClass('show');
            },
            error : function(XMLHttpRequest, textStatus, errorThrown){
                alert(textStatus);
            }
        
        })
        return false;
    })

    $(".myoptions").click(function (){
        page=$(this).attr("href");
        $.ajax({
            url : "forms/"+page,
            cache : false,
            success : function(html){
                afficher(html);
                $('.user-options').toggleClass('show');
                $('.user-options').toggleClass('hide');
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

function secure_nds(){
    if (mynds=="w"){
        document.getElementById('collab_consult').disabled = 'true';
    }
    if (mynds=="r"){

        elmts = document.getElementsByClassName("edit-nds");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        elmts = document.getElementsByClassName("del-nds");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        document.getElementById('btn-add').style.display = 'none';
    }
};
function secure_client(){
    if (mynds=="w"){
        elmts = document.getElementsByClassName("del-cli");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
    }
    if (mynds=="r"){

        elmts = document.getElementsByClassName("edit-cli");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        elmts = document.getElementsByClassName("del-cli");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        document.getElementById('btn-add').style.display = 'none';
    }
};
function secure_contrat(){
    if (mynds=="w"){
        elmts = document.getElementsByClassName("del-cont");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
    }
    if (mynds=="r"){

        elmts = document.getElementsByClassName("edit-cont");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        elmts = document.getElementsByClassName("del-cont");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        document.getElementById('btn-add').style.display = 'none';
    }
};
function secure_collab(){
    if (mynds=="w"){
        elmts = document.getElementsByClassName("del-collab");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
    }
    if (mynds=="r"){

        elmts = document.getElementsByClassName("edit-collab");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        elmts = document.getElementsByClassName("del-collab");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        document.getElementById('btn-add-collab').style.display = 'none';
    }
};
function secure_affect(){
    if (myaffect=="w"){
        elmts = document.getElementsByClassName("del-affect");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
    }
    if (mynds=="r"){

        elmts = document.getElementsByClassName("edit-affect");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        elmts = document.getElementsByClassName("del-affect");
        for(var i=0;i<elmts.length;i++)
            {
                elmts[i].setAttribute( 'style', 'display:none' );
            }
        if (document.getElementById('add-affect')){
            document.getElementById('add-affect').style.display = 'none';
        }
        if (document.getElementById('add_affect_cont')){
            document.getElementById('add_affect_cont').style.display = 'none';
        }
        // document.getElementById('add_affect_cont').style.display = 'none';
    }
};