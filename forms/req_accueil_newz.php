<?php
	session_start();
	setlocale(LC_TIME, "fr_FR.utf8");
	try {
		$db = new PDO('mysql:host=neris_extranet.mysql.db;dbname=neris_extranet;charset=utf8', 'neris_extranet', 'fc2YUH9xMku9');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
		catch(PDOException $e)
	{
		echo $e->getMessage();
	}

	// $myid = $_SESSION['auth']['myid'];
	$sql = "SELECT news.date as date, news.commentaire as news, collaborateurs.nom_usage as collab FROM (news INNER JOIN collaborateurs ON news.id_collab = collaborateurs.id) ORDER BY date DESC LIMIT 10";
	$stnews = $db->query($sql);
	$list_news = $stnews->fetchall();



	echo "<div class='box-body chat' id='chat-box'>";
	foreach ($list_news as $row) {
		echo "<div class='item'>";
	        echo "<img src='dist/img/user9-160x160.jpg' alt='user image' />";
	        echo "<p class='message'>";
				echo "<a href='#' class='name'>";
					echo "<small class='text-muted pull-right'><i class='fa fa-clock-o'></i> ".date('d/m/Y H:i:s', strtotime($row[0]))."</small>";
					echo $row[2];
				echo "</a>";
				echo $row[1];
	        echo "</p>";
	      echo "</div>";
    };
    echo "</div>";



?>
