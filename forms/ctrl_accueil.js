$(function() {
        
        
	$(document).ready(function(){
        var collab_id = myid;
        $.ajax({
        	type: "POST",
			url: "forms/req_accueil.php",
			data: "collab_id="+ collab_id, // on envoie $_GET['go']
			datatype: "html", // on veut un retour JSON
			success: function(data) {
				$('#listNDS').html(data);

			}
        });
        $.ajax({
        	type: "POST",
			url: "forms/req_accueil_widgHours.php",
			data: "collab_id="+ collab_id, // on envoie $_GET['go']
			datatype: "html", // on veut un retour JSON
			success: function(data) {
				$('#WidgHours').html(data);

			}
        });
        $.ajax({
        	type: "POST",
			url: "forms/req_accueil_newz.php",
			data: "", // on envoie $_GET['go']
			datatype: "html", // on veut un retour JSON
			success: function(data) {
				$('#listnews').html(data);
				document.getElementById('comment').value = "";
			}
        });
 	});
	$(document).on('click','#btn_add_news',function(){
		var commentaire = $('#comment').val();
		$.ajax({
        	type: "POST",
			url: "forms/req_accueil_add_news.php",
			data: "comment="+commentaire+"&myid="+myid, // on envoie $_GET['go']
			datatype: "html", // on veut un retour JSON
			success: function(data) {
				$.ajax({
		        	type: "POST",
					url: "forms/req_accueil_newz.php",
					data: "", // on envoie $_GET['go']
					datatype: "html", // on veut un retour JSON
					success: function(data) {
						$('#listnews').html(data);
					}
		        });
			}
        });
        document.getElementById('comment').value = "";
	});
 	$(document).on('click','.details_hour',function (){

 		contrat_id = this.id;
 		$.ajax({
            url : "forms/tdb/hour/tdb_heures.php",
            cache : false,
            success : function(html){
                afficher(html);
            },
            error : function(XMLHttpRequest, textStatus, errorThrown){
                alert(textStatus);
            }
        
        })
        annees = document.getElementById('annee'+contrat_id).innerHTML;
        setTimeout(function(){
            $.ajax({
        		type: "POST",
	            url: "forms/tdb/hour/req_tdb_heures.php",
	            data: "contrat_id="+contrat_id+"&annees="+annees, // on envoie $_GET['go']
	            datatype: "html", // on veut un retour HTML
	            success: function(data) {
	                $('.afficher').html(data);
	                $('#icon-hour').removeClass('fa-chevron-down');
	                $('#icon-hour').addClass('fa-chevron-up');
	                $('#table-hour').addClass('hide');
	                $('#table-bilan-hour').addClass('hide');
	                $('#icon-bilan-hour').removeClass('fa-chevron-down');
	                $('#icon-bilan-hour').addClass('fa-chevron-up');
            	}
        	});
        }, 500);
        
        return false;
 	});

 	function afficher(html){
		$("#content").fadeOut(250,function(){
	    $("#content").empty();
	    $("#content").append(html);
	    $("#content").fadeIn(500);
	})
};
});