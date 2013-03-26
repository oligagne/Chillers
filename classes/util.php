<?php
	//session_start();
	//header("Cache-control: private");
	function validateUser()
	{
		//printf("IN: valide : %s", $_SESSION['username']);
		return isset($_SESSION["username"]);
	}
	
	function rankgen($posdebut,$posfin)
	{
		echo "<br>";
		//ajouter la classe pour la bd
		require_once("class_connect.php");
		$dbCat = new connection;
		//Code pour le classement. On tri avec SQL
		$query = "SELECT * FROM pool_stats ORDER BY rank"; //ou nb_total DESC
		$dbCat->query($query);
		$dbNom = new connection;
		if ( $dbCat->num_rows() >= 1 ) 
		{
			$dbCat->next_record();
			$z = $dbCat->num_rows();
			for($i=0; $i<$z; $i++) //parcours tous les joueurs en ordre de rang.
			{
				$forname = "SELECT nom FROM pool_users WHERE id_users =" . $dbCat->Record["id_users"];
				$dbNom->query($forname);
				$dbNom->next_record();
				$ro = $i +1;
				if ( $ro >=  $posdebut && $ro <= $posfin )
					echo "<b><a href=stats.php?team=". $dbCat->Record["id_users"] ." class=pool> <font color=9A3725> " . $ro .  ". </font>&nbsp;" .  $dbCat->Record["team"] . " [ ". $dbCat->Record["nb_pts"] ." pts ]<br><br>"; 
					
				$dbCat->next_record();				
			}
		}
	}	
	function play2night($team)
	{
		require_once("class_connect.php");
		$dbCat = new connection;
		//Code pour la game du soir
		$today = date("Y-m-d"); 
	//	printf("team = %s",$team);
		$query = "SELECT * FROM pool_games WHERE date_game = '" . $today . "' AND (local = '". $team . "' OR visiteur = '" . $team . "')"; //ou nb_total DESC
		$dbCat->query($query);
		$dbNom = new connection;
		if ( $dbCat->num_rows() >= 1 ) 
		{
			return 1;
		}
		return 0;
	}
	
	function played($team)
	{
		require_once("class_connect.php");
		$dbCat = new connection;
		//Code pour la game du soir
		//$yesterday  = mktime(0, 0, 0, date("Y"), date("m")  , date("d")-1 );
		//$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),  date("Y"));
		$yesterday = strftime ("%Y-%m-%d", strtotime("-1 day"));
		//printf("team = %s",$yesterday);
		$query = "SELECT * FROM pool_games WHERE date_game = '" . $yesterday . "' AND (local = '". $team . "' OR visiteur = '" . $team . "')"; //ou nb_total DESC
		$dbCat->query($query);
		$dbNom = new connection;
		if ( $dbCat->num_rows() >= 1 ) 
		{
			return 1;
		}
		return 0;
	}
	
	
?>