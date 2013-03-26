<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
	if ( isset( $_GET['id'] ) )
	{
		require_once("CChillers.php");
		$c = new chillersDB;
		$c->DisableComment( $_GET['id'] );		
	} 
	if(isset($_GET['action']))  
	{
		require_once("CChillers.php");
		$c = new chillersDB;
		if ( $_GET['action'] == "AddChillers")
		{
			$c->AddChillers($_REQUEST['ChillerName'],$_REQUEST['ChillerPosition'],$_REQUEST['ChillerNumber']);		
		}
		
		if ( $_GET['action'] == "AddMatch")
		{
			$c->AddMatch($_REQUEST['MatchDate'],$_REQUEST['MatchHeure'],$_REQUEST['MatchGlace'],$_REQUEST['MatchVisiteur']);		
		}		
		
		if ( $_GET['action'] == "AddStars") 
		{
			$idCal = $_REQUEST['MatchId'];
			list($id1, $name1) = split('/', $_REQUEST['star1']);
			list($id2, $name2) = split('/', $_REQUEST['star2']);
			list($id3, $name3) = split('/', $_REQUEST['star3']);
			$c->AddStar($idCal,1,$name1,$id1,$_REQUEST['Comment1']);
			$c->AddStar($idCal,2,$name2,$id2,$_REQUEST['Comment2']);
			$c->AddStar($idCal,3,$name3,$id3,$_REQUEST['Comment3']);
		}
		
		if ( $_GET['action'] == "ModScore") 
		{
			$c->UpdateMatch($_GET['MatchId'], $_REQUEST['ChillerScore'], $_REQUEST['VisiteurScore'], $_REQUEST['description']);
		}
		
		if ( $_GET['action'] == "NewStats")  //Game Stats
		{
			$nbPlayers = $_POST['nb_playersUp'];
			$matchId   = $_POST['MatchUpId'];	
		   //faut faire l'update pour chaque joueurs
		   echo "Nb Player" . $nbPlayers . "  mathch Id " . $matchId;
		   for($x=0;$x<$nbPlayers;$x++)
		   {
				$varPosted1 = "nbmj" . $x;
				$varPosted2 = "nbbuts" . $x;
				$varPosted3 = "nbas" . $x;
				$varPosted4 = "id_playersUP" . $x;
				$varPosted5 = "nbminput" . $x;
				
				//take it;
				$NBMATCH = $_POST[$varPosted1];
				$NBGOAL = $_POST[$varPosted2];
				$NBASS = $_POST[$varPosted3];
				$IDPLAYERS = $_POST[$varPosted4];
				$PUNITION  = $_POST[$varPosted5];
				$c->AddStats($matchId,$IDPLAYERS,$NBMATCH,$NBGOAL,$NBASS,$PUNITION);				
			} 	
		}
		if ( $_GET['action'] == "MAJChillers")  //Game Stats
			{
				$nbPlayers = $_POST['nb_players'];
			   	for($x=0;$x<$nbPlayers;$x++)
			   	{
					$varName 	= "name" . $x;
					$varNum		= "number" . $x;
					$varMJ 		= "nbmj" . $x;
					$varButs 	= "nbbuts" . $x;
					$varAss 	= "nbas" . $x;
					$varId 		= "id_players" . $x;
					$varPun 	= "nbminput" . $x;
					$varPhone	= "phone" . $x;
					$varAnnee	= "annee" . $x;
					$varPosition	= "position" . $x;
					$varDescription	= "desciption" . $x;
					//take it;
					$NAME  = $_POST[$varName];
					$NUMBER = $_POST[$varNum];
					$NBMATCH = $_POST[$varMJ];
					$NBGOAL = $_POST[$varButs];
					$NBASS = $_POST[$varAss];
					$IDPLAYERS = $_POST[$varId];
					$PUNITION  = $_POST[$varPun];
					$PHONE = $_POST[$varPhone];
					$ANNEE = $_POST[$varAnnee];
					$POSITION = $_POST[$varPosition];
					$DESCRIPTION = $_POST[$varDescription];
					$modChiller = new Chillers($NAME,$POSITION,$NUMBER,$NBMATCH,$NBGOAL,$NBASS,$NBGOAL+$NBASS,$PUNITION,"",$PHONE,$DESCRIPTION,$IDPLAYERS);
					$modChiller->setDate($ANNEE);
					$c->ModifyChillers($modChiller);				
				}
			}
	}		
	 



?>




<body>
<TABLE>
<form name="AddChillers" method="post" action="AdminPage.php?action=AddChillers">
<tr><td>Prenom et Nom</td><td><input type="text" name="ChillerName"></td></tr>
<tr><td>Numéro</td><td><input type="text" name="ChillerNumber"></td></tr> 
<tr><td>Position</td><td><select name="ChillerPosition">
    <option value="Avant">Avant</option>
    <option value="Defenseur">D&eacute;fenseur</option>
    <option value="Goaler">Goaler</option>
  </select></td>
 </tr>
<tr><td><input type="submit" name="Submit" value="Habiller un chiller"></td></tr>     
</form>
</TABLE>
<br><br>

<TABLE>
<form name="AddMatch" method="post" action="AdminPage.php?action=AddMatch">
<tr><td>Date(yyyy-MM-dd)</td><td><input type="text" name="MatchDate"></td></tr>
<tr><td>Heure(hh:mm)</td><td><input type="text" name="MatchHeure"></td></tr> 
<tr><td>Glace</td><td><input type="text" name="MatchGlace"></td></tr>
<tr><td>Visiteur</td><td><input type="text" name="MatchVisiteur"></td></tr>
<tr><td><input type="submit" name="Submit" value="Combat en règle!"></td></tr>  
</form>
</TABLE>
<br><br>

<TABLE>
<tr><td>Nom</td><td>PJ</td><td>Buts</td><td>Ass</td><td>PTS</td><td>Pun</td></tr>
<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	for($i=0; $i<$z; $i++)
	{	
		echo "<tr><td>". $chill->dbCat->Record["j_name"] . "</td><td>". $chill->dbCat->Record["j_pj"] . "</td><td>" . 
		$chill->dbCat->Record["j_but"] . "</td><td>" . $chill->dbCat->Record["j_ass"] . "</td><td>" . $chill->dbCat->Record["j_pts"] . "</td><td>" . 
		$chill->dbCat->Record["j_minutesPun"] . "</td></tr>";
		$chill->dbCat->next_record();
	}
?>
</TABLE>


<br><br>

<TABLE>
<tr><td>Date Heure</td><td>Glace</td><td>Local</td><td>Visteur</td><td></td></tr>
<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllMatchs(2012,2013);
	$z = $chill->dbCat->num_rows();
	if ( $z > 0 )
	{
		$z = $chill->dbCat->num_rows();
	}
	$chill->dbCat->next_record(); 
	
	for($i=0; $i<$z; $i++)
	{	
		echo "<tr><td>". $chill->dbCat->Record["c_date"] . " " . $chill->dbCat->Record["c_hrs"] . "</td><td>". $chill->dbCat->Record["c_glace"] . "</td><td> 
		Chillers [ " . $chill->dbCat->Record["c_chillersBut"] . " ]</td><td>" .  $chill->dbCat->Record["c_visiteur"] . "[" . $chill->dbCat->Record["c_visiteurBut"]  .   "]</td>";
		echo "<td><a href=modScore.php?MatchId=". $chill->dbCat->Record["id"] .  "> Modifier Score </a> </td>";
		echo "</tr>";
		$chill->dbCat->next_record();
	}
?>
</TABLE>


<TABLE>
<form name="AddStars" method="post" action="AdminPage.php?action=AddStars">
<tr><td>Partie</td>
	<td>
	<?php
		require_once("CChillers.php");
		$chill = new chillersDB;
		$allRow = $chill->GetAllMatchs(2012,2013);
		$z = $chill->dbCat->num_rows();
		if ( $z > 0 )
		{
			$z = $chill->dbCat->num_rows();
		}
		$chill->dbCat->next_record(); 
		echo "<select name=MatchId>";
		for($i=0; $i<$z; $i++)
		{	
			echo " <option value=". $chill->dbCat->Record["id"].">" . $chill->dbCat->Record["c_date"] . "</option>";
			$chill->dbCat->next_record();
		}
		echo "</select>";
	?>
	</td>
</tr>

     

<tr><td>Étoile 1</td><td>
<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	echo "<select name=star1>";
	for($i=0; $i<$z; $i++)
	{	
		echo " <option value=". $chill->dbCat->Record["id"]."/".  $chill->dbCat->Record["j_name"] . ">" .$chill->dbCat->Record["j_name"] . "</option>";
		$chill->dbCat->next_record();
	}
	echo "</select>";
?>


</td>
<td>Comments</td><td><input type="text" name="Comment1"></td></tr> 
<tr><td>Étoile 2</td><td><?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	echo "<select name=star2>";
	for($i=0; $i<$z; $i++)
	{	
		echo " <option value=". $chill->dbCat->Record["id"]."/".  $chill->dbCat->Record["j_name"] . ">" .$chill->dbCat->Record["j_name"] . "</option>";
		$chill->dbCat->next_record();
	}
	echo "</select>";
?></td>
<td>Comments</td><td><input type="text" name="Comment2"></td></tr> 
<tr><td>Étoile 3</td><td><?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	echo "<select name=star3>";
	for($i=0; $i<$z; $i++)
	{	
		echo " <option value=". $chill->dbCat->Record["id"]."/".  $chill->dbCat->Record["j_name"] . ">" .$chill->dbCat->Record["j_name"] . "</option>";
		$chill->dbCat->next_record();
	}
	echo "</select>";
?></td>
<td>Comments</td><td><input type="text" name="Comment3"></td></tr>
<tr><td><input type="submit" name="Submit" value="Collez une étoile!"></td></tr>  
</form>
</TABLE> 

<br><br>
<hr>
<form name="AddMatch" method="post" action="AdminPage.php?action=NewStats">
<table>
<tr><td>Partie</td>
	<td>
	<?php
		require_once("CChillers.php");
		$chill = new chillersDB;
		$allRow = $chill->GetAllMatchs(2012,2013);
		$z = $chill->dbCat->num_rows();
		if ( $z > 0 )
		{
			$z = $chill->dbCat->num_rows();
		}
		$chill->dbCat->next_record(); 
		echo "<select name=MatchUpId>";
		for($i=0; $i<$z; $i++)
		{	
			echo " <option value=". $chill->dbCat->Record["id"].">" . $chill->dbCat->Record["c_date"] . "</option>";
			$chill->dbCat->next_record();
		}
		echo "</select>";
	?>
	</td>
</tr>



<tr><td>Joueurs</td><td>MJ</td><td>Buts</td><td>Passes</td><td>Min</td></tr>
<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	for($i=0; $i<$z; $i++)
	{	
		echo "<tr>";
		echo "<TD>" . $chill->dbCat->Record["j_name"] . "</TD>"; 
	    echo "<TD align=center><input name=nbmj". $i ." type=text size=2 maxlength=2 value=" . 0 ."></TD>";
		echo "<TD align=center><input name=nbbuts". $i ." type=text size=2 maxlength=2 value=" . 0 ."></TD>";
		echo "<TD align=center><input name=nbas". $i ." type=text size=2 maxlength=2 value=" . 0 ."></TD>";
		echo "<TD align=center><input name=nbminput". $i ." type=text size=2 maxlength=2 value=" . 0 ."></TD>";
		echo "<input name=id_playersUP". $i." type=hidden value=".$chill->dbCat->Record["id"] .">";
		echo "</tr>";										
		$chill->dbCat->next_record();
	}
?>
	</table>
	<input name="nb_playersUp" type="hidden" value="<?php echo $z ?>" >
	<input name="" type="submit" value="Add Game Stats" style="background: #000000; font-family: verdana;font-size:9; color:#FFFFFF">
	</form>











<br><br>
<hr>
<form name="MAJChillers" method="post" action="AdminPage.php?action=MAJChillers">
<table>
<tr><td>Number</td><td>Joueurs</td><td>MJ</td><td>Buts</td><td>Passes</td><td>Total</td><td>Min</td><td>Phone</td><td>Année</td><td>Position</td><td>Description</td></tr>
<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->GetAllChillers(2012);
	$chill->dbCat->next_record(); 
	$z = $chill->dbCat->num_rows();
	for($i=0; $i<$z; $i++)
	{	
		echo "<tr>";
		
		echo "<TD align=center><input name=number". $i ."  value='" . $chill->dbCat->Record["j_number"] ."'></TD>"; 
		echo "<TD align=center><input name=name". $i ."  value='" . $chill->dbCat->Record["j_name"] ."'></TD>"; 
	    echo "<TD align=center><input name=nbmj". $i ." type=text size=2 maxlength=2 value=" . $chill->dbCat->Record["j_pj"] ."></TD>";
		echo "<TD align=center><input name=nbbuts". $i ." type=text size=2 maxlength=2 value=" .$chill->dbCat->Record["j_but"] ."></TD>";
		echo "<TD align=center><input name=nbas". $i ." type=text size=2 maxlength=2 value=" . $chill->dbCat->Record["j_ass"] ."></TD>";
		$total = $chill->dbCat->Record["j_but"] + $chill->dbCat->Record["j_ass"];
		echo "<TD align=center>". $total ."</TD>";
		echo "<TD align=center><input name=nbminput". $i ." type=text size=2 maxlength=2 value=" . $chill->dbCat->Record["j_minutesPun"] ."></TD>";
		echo "<TD align=center><input name=phone". $i ." type=text size=10 maxlength=10 value=" . $chill->dbCat->Record["j_phone"] ."></TD>";
		echo "<TD align=center><input name=annee". $i ." type=text size=4 maxlength=4 value=" . $chill->dbCat->Record["j_annee"] ."></TD>";
		echo "<TD align=center><input name=position". $i ."  value=" . $chill->dbCat->Record["j_position"] ."></TD>";
		echo "<TD align=center><input name=desciption". $i ." type=text size=100  value='" . $chill->dbCat->Record["j_desc"] ."'></TD>";
		echo "<input name=id_players". $i." type=hidden value=".$chill->dbCat->Record["id"] .">";
		echo "</tr>";										
		$chill->dbCat->next_record();
	}
?>
	</table>
	<input name="nb_players" type="hidden" value="<?php echo $i ?>" >
	<input name="" type="submit" value="Update Chillers" style="background: #000000; font-family: verdana;font-size:9; color:#FFFFFF">
	</form>









<br><br>

<br><br>


<?php
	require_once("CChillers.php");
	$chill = new chillersDB;
	$allRow = $chill->DisplayAllComments();
	$z = $chill->dbCat->num_rows();
	if ( $z > 0 )
	{
		$z = $chill->dbCat->num_rows();
	}
	$chill->dbCat->next_record(); 
	
	for($i=0; $i<$z; $i++)
	{	
		echo "<TABLE><tr valign=top><td valign=top><b>". $chill->dbCat->Record["c_name"] . "</b></td></tr>";
		echo "<tr valign=top><td valign=top>" . $chill->dbCat->Record["c_comment"] . "</td></tr>";
		echo "<tr><td><a href=AdminPage.php?id=". $chill->dbCat->Record["id"] .  "> Modifier Commentaire </a> </td>";
		echo "</tr></TABLE>";
		$chill->dbCat->next_record();
	}
?>



</body>
</html>
