<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
		
		if ( isset( $_GET['MatchId'] ) )
		{
			require_once("CChillers.php");
			$c = new chillersDB;
			$c->GetMatchInfo( $_GET['MatchId'] );
			$c->dbCat->next_record(); 
			$z = $c->dbCat->num_rows();
			if ( $z > 0 )
			{ ?>
			<table>
				<form name="UpdateMatch" method="post" action="AdminPage.php?action=ModScore&MatchId= <?php echo $_GET['MatchId'];?>">
				<tr><td>Chillers Score :</td><td><input type="text" name="ChillerScore"></td></tr>
				<tr><td><?php echo $c->dbCat->Record["c_visiteur"] . " Score :"; ?></td><td><input type="text" name="VisiteurScore"></td></tr> 
				<tr><td>Actif</td><td><select name="isActif" size="1">
      			<option value="Vrai">Vrai</option>
      			<option value="Faux">Faux</option>
   				</select></td></tr>
				<tr><td>Description</td><td><textarea name="description" cols="15" rows="5"></textarea></td></tr>
				<tr><td><input type="submit" name="Submit" value="Combat en réglé!"></td></tr>  

				</form>
				</table>
<?php
			}

		
		
		} 

?>
</html>