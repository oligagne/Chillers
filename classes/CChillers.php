<?php


class chillersDB
{		
	var $dbCat; 
	function chillersDB()
	{
		require_once("class_connect.php");
		$this->dbCat = new connection;
	}
	
	function AddChillers($name, $position, $number) //Ok
	{	
		$year = date("Y"); 
		$newChillers = "INSERT INTO c_players (j_name, j_position, j_number, j_annee, j_actif) VALUES('" . $name . "','" . $position . "'," . $number . ",'" . $year . "' , 1)"; 
		echo $newChillers;
		$this->dbCat->query($newChillers);
	}
	
	function ModifyChillers($chillers) 
	{
	   $modChillers = "UPDATE c_players SET j_name= '" . $chillers->m_name . "', j_number= ". $chillers->m_number . ", j_pj = " . $chillers->m_pj .", j_but = " . $chillers->m_but . 
	   ", j_ass = " . $chillers->m_ass . ", j_pts = " . $chillers->m_pts . ", j_minutesPun = ". $chillers->m_minutesPun . ", j_link = '" . $chillers->m_link . "', j_phone = '" . $chillers->m_phone . "', j_desc = '" . $chillers->m_desc  .
	   "' , j_position = '" . $chillers->m_position . "', j_annee = ".  $chillers->m_annee  . " WHERE id=" . $chillers->id;
	   $this->dbCat->query($modChillers);
	}
	
	function FindChillers($id)
	{	
	   // Get all the data from the "example" table
	   $result = $this->dbCat->query("SELECT * FROM c_players WHERE id =" . $id);
	   $row = mysql_fetch_array( $result );  
	   return new Chillers($row['j_name'],$row['j_position'],$row['j_number'],$row['j_pj'],$row['j_but'],$row['j_ass'],$row['j_pts'],$row['j_minutesPun'],$row['j_link'],$row['j_phone'],$row['j_desc'],$id);
	}
	
	function GetAllChillers($year)
	{//
		$getAllC = "SELECT  * FROM c_players WHERE j_annee = '" . $year . "' AND  j_actif <> false  ORDER BY j_pts desc, j_but desc";
		return $this->dbCat->query($getAllC);
	}
	
	function GetAllChillersExceptG($year)
	{
		$getAllC = "SELECT  * FROM c_players WHERE j_annee = '" . $year . "' AND j_actif <> false AND j_position <> 'Goaler' ORDER BY j_pts desc, j_but desc, j_pj";
		return $this->dbCat->query($getAllC);
	}
	
	function GetGoaler($year)
	{
		$getAllC = "SELECT  * FROM c_players WHERE j_annee = '" . $year . "' AND j_actif <> false AND j_position = 'Goaler' ORDER BY j_pts desc";
		return $this->dbCat->query($getAllC);
	}
	
	

	function AddStats($IDMATCH,$IDPLAYERS,$NBMATCH,$NBGOAL,$NBASS,$PUNITION)
	{
		$newMatch = "INSERT INTO c_stats (s_idMatch, s_idJoueurs, s_pj, s_but, s_ass, s_pts, s_minutesPun) VALUES(" . $IDMATCH . " , " . $IDPLAYERS . " , " . $NBMATCH . " , " . $NBGOAL . " , " . $NBASS . " , " .  ($NBGOAL + $NBASS) . " , " . $PUNITION . ")"; 
		$this->dbCat->query($newMatch);
		$this->UdapteStats($IDPLAYERS,$NBMATCH,$NBGOAL,$NBASS,$PUNITION);
	}

	function UdapteStats($id, $nbM, $but, $pass, $min)
	{
		$getPlayers = "SELECT * FROM c_players WHERE id=" . $id;
		$result = $this->dbCat->query($getPlayers);		
		$this->dbCat->next_record(); 
		
		$TotalMatch = $this->dbCat->Record["j_pj"] + $nbM;
		$TotalButs = $this->dbCat->Record["j_but"] +  $but;
		$TotalAss = $this->dbCat->Record["j_ass"] + $pass;
		$TotalPTS = $TotalButs + $TotalAss;
		$TotalMin = $this->dbCat->Record["j_minutesPun"] + $min;
	
	
		$updateStats = "UPDATE c_players SET j_pj = " . $TotalMatch .", j_but = " . $TotalButs . " , j_ass = " . $TotalAss .  ", j_pts = " . $TotalPTS. ", j_minutesPun = ". $TotalMin .
	   	" WHERE id=" . $id;
		$this->dbCat->query($updateStats);
	}
	
	function AddMatch($date, $heure, $glace, $visiteur) //Ok
	{
		$newMatch = "INSERT INTO c_calender (c_date, c_hrs, c_glace, c_visiteur, c_actif) VALUES('" . $date . "','" . $heure . "','" . $glace . "','" . $visiteur . "' , 1)"; 
		$this->dbCat->query($newMatch);
	}
	
	function GetNbVictoires() //Ok
	{
		$newMatch = "SELECT COUNT(*) FROM c_calender WHERE c_victoire = 1"; 
		$this->dbCat->query($newMatch);
		$this->dbCat->next_record(); 
		return $this->dbCat->Record[0];
	}
	
	function GetNbDefaites() //Ok
	{
		$newMatch = "SELECT COUNT(*) FROM c_calender WHERE c_victoire = -1"; 
		$this->dbCat->query($newMatch);
		$this->dbCat->next_record(); 
		return $this->dbCat->Record[0];
	}
	
	function GetNbNulls() //Ok
	{
		$newMatch = "SELECT COUNT(*) FROM c_calender WHERE c_victoire = 0"; 
		$this->dbCat->query($newMatch);
		$this->dbCat->next_record(); 
		return $this->dbCat->Record[0];
	}
	
	function GetNbButsPour()
	{
		$newMatch = "SELECT SUM(c_chillersBut) FROM c_calender WHERE c_actif = 1"; 
		$this->dbCat->query($newMatch);
		$this->dbCat->next_record(); 
		return $this->dbCat->Record[0];
	}
	
	function GetNbButsContre()
	{
		$newMatch = "SELECT SUM(c_visiteurBut) FROM c_calender WHERE c_actif = 1"; 
		$this->dbCat->query($newMatch);
		$this->dbCat->next_record(); 
		return $this->dbCat->Record[0];
	}
	
	function UpdateMatch($id_match, $chillers_score, $ad_score, $desc)
	{
		$vic = 1; //1 victoire -1 ; defait ; 0 null
		if ( $chillers_score < $ad_score )
		{
				$vic = -1;
		}
		else if (  $chillers_score == $ad_score )
		{
			$vic = 0;
		}
		$updateStats = "UPDATE c_calender SET c_chillersBut = '" . $chillers_score . "' , c_visiteurBut = " . $ad_score .  ", c_desc = '" . $desc . "', c_victoire = ". $vic .
	   	" WHERE id=" . $id_match;
		$this->dbCat->query($updateStats);	
	}
	
	function GetAllMatchs($year1,$year2)
	{	
		$getAllC = "SELECT  * FROM c_calender WHERE (YEAR(c_date) = '". $year1 . "' OR YEAR(c_date) = '". $year2 . "') AND c_actif <> false";
		return $this->dbCat->query($getAllC);
	}
	
	function GetMonthMatchs($year1,$mois1)
	{	
		$getAllC = "SELECT  * FROM c_calender WHERE (YEAR(c_date) = '". $year1 . "' AND MONTH(c_date) = '". $mois1 . "') AND c_actif <> false ORDER by c_date";
		return $this->dbCat->query($getAllC);
	}
	
	function GetMatchInfo($matchId)
	{	
		$getAllC = "SELECT  * FROM c_calender WHERE id =" . $matchId;
		return $this->dbCat->query($getAllC);
	}
	
	
	function AddComment($name, $comment, $link)
	{
		$newComment = "INSERT INTO c_comments (c_date, c_name, c_comment, c_display, c_link) VALUES('" . date("Y-M-D hh:mm:ss") . "','" . $name . "','" . $comment . "'," . true . ",'" . $link . "')"; 
		$this->dbCat->query($newComment);
	}
	
	function DisableComment($id)
	{
		$disableComment = "UPDATE c_comments SET c_display = false WHERE id=" . $id;
		$this->dbCat->query($disableComment);
	}

	
	function DisplayComments($page) //10 par pages (voir pool?)	{}
	{
		$comentNbByPage = 18;
		$getAllC = "SELECT  * FROM c_comments WHERE c_display = true ORDER by id desc LIMIT " . ($page-1)*$comentNbByPage . "," . ($page*$comentNbByPage);
		return $this->dbCat->query($getAllC);
	}
	
	function DisplayAllComments() //10 par pages (voir pool?)	{}
	{
		$getAllC = "SELECT  * FROM c_comments WHERE c_display = true";
		return $this->dbCat->query($getAllC);
	}
	
	function FindStars()
	{
		$getLastGame = "SELECT * FROM c_calender WHERE c_date < '" .  date("Y-M-D") ."' AND c_chillersBut > 0 OR c_visiteurBut > 0 ORDER by c_date desc";
			$result = $this->dbCat->query($getLastGame);
		
		
		if ( $this->dbCat->next_record() )
		{
		$idGame = $this->dbCat->Record["id"];
		
		$getStars = "SELECT * FROM c_stars WHERE c_calenderId = " . $idGame . " ORDER by c_rank";
		//echo $getStars;
		return  $this->dbCat->query($getStars); //return the 3 game stars
		}		
	}
	
	function addStar($calId, $rank, $name, $playerId, $comment) 
	{	
		$newChillers = "INSERT INTO c_stars (c_calenderId, c_rank, c_name, c_playerId, c_comment) VALUES(" . $calId . "," . $rank . ",'" . $name . "'," . $playerId. ", '". $comment . "' )"; 
		echo $newChillers;
		$this->dbCat->query($newChillers);
	}
};



class Chillers //$x = new Chillers('Ego');
{
	var $id;
 	var $m_name;
 	var $m_position;
 	var $m_number;
 	var $m_pj;
 	var $m_but;
 	var $m_ass = 0;
 	var $m_pts;
 	var $m_minutesPun;
 	var $m_link;
 	var $m_phone;
 	var $m_desc;
	var $m_annee;
	
 	 function Chillers($name,$position,$number,$pj,$but,$ass,$pts,$minPun,$link,$phone,$desc,$idC)
 	 { 	 

 	 	$this->m_name  = $name;
		$this->m_position = $position;
	 	$this->m_number = $number;
	 	$this->m_pj = $pj;
		if ( $this->m_pj == "" )  $this->m_pj = 0;
		
	 	$this->m_but = $but;
		if ( $this->m_but == "" ) $this->m_but =0;
	 	$this->m_ass = $ass;
		if ( $this->m_ass == "" ) $this->m_ass = 0;
		$this->m_pts = $pts;
		if ( $this->m_pts == "" ) $this->m_pts = 0;
	 	$this->m_minutesPun = $minPun;
		if ( $this->m_minutesPun  == "") $this->m_minutesPun  = 0;
	 	$this->m_link = $link;
	 	$this->m_phone = $phone;
	 	$this->m_desc = $desc; 
		$this->id = $idC;	 
 	 }	
	 
	 function setDate($date)
	 {
	 	$this->m_annee = $date;	
	 }

};

?>