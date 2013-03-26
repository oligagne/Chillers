<HTML>
<HEAD>
<TITLE>Chillers</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="chillers.css" rel="stylesheet" type="text/css">
</HEAD>
<body style="overflow:auto">
     

<?php
	//Redirect to mobile website.
	//$ua=$_SERVER['HTTP_USER_AGENT'];
	//echo "<font color=red>" . $ua . "  " . preg_match('/Mobile|iPhone|iPad/',$ua) . "</font>";
	//if(preg_match('/Mobile|iPhone|iPad|Nexus 7/',$ua)) header('Location:http://www.chillershockey.org/mobile/');
		include 'Mobile_Detect.php';
		$detect = new Mobile_Detect();
		if ($detect->isMobile()) {
			// Any mobile device.
			header('Location:http://www.chillershockey.org/mobile/');
		}
	
	if ( isset($_GET['action']) && $_GET['action'] == "AddComment") 
	{
		require_once("classes/CChillers.php");
		$c = new chillersDB;
		//$trans = array("'" => "''");
		$News = $_REQUEST['ChillersComment'];
		//$News = strtr($News, $trans);
		

	
			$strNews = strtolower($News);
			$http = strtolower("http");
			$href = strtolower("href");
		   
		if (  strstr($strNews,$http) == false  && strstr($strNews,$href) == false  )
		{
		 		$c->AddComment($_REQUEST['Nom'],$News,"");
		}	
	} 

	//variables pour les mois
	$prec = date("m")-1;
	$suiv = date("m")+1;
	if ( isset($_GET['Offset']) )
	{
		$prec = $_GET['Offset']-1;
		$suiv = $_GET['Offset']+1;
	}
	


?>

<div class="pool" >

<div id="image">
  <a id="back" href="index.php?Offset=<?php echo $prec ?>" title="Mois Précédant"></a>
  <a id="next" href="index.php?Offset=<?php echo $suiv ?>" title="Mois Suivant"></a>
</div>


<div class="tabStars">
	    <?php
	
		require_once("classes/CChillers.php");
		
		
		$chill = new chillersDB;
		$allRow = $chill->FindStars();
		$z = $chill->dbCat->num_rows();
		if ( $z > 0 )
		{
			$chill->dbCat->next_record(); 
		}	
		echo "<table>";
		for($i=0; $i<$z; $i++)
		{	
			echo "<tr><td valign=top><img src=images/star" . ($i+1) . ".gif><font size=2>     <b>" . $chill->dbCat->Record["c_name"] . "</b>      " . $chill->dbCat->Record["c_comment"] . "</font></td></tr>";
			$chill->dbCat->next_record();
		}
		echo "</table>"
		?>
</div>		


</div>		

<div class="tabMatchs">
	<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
		<tr class="tabHeader"><td width="79">Date </td><td width="65"> Heure</td><td width="35">Glace</td><td width="135">Local</td><td width="135">Visiteur</td></tr>
		<tr><td width="79"> </td><td width="65"> </td><td width="35"></td><td width="135"></td><td width="135"></td></tr>
		<tr><td width="79"> </td><td width="65"> </td><td width="35"></td><td width="135"></td><td width="135"></td></tr>
	
			<?php
			require_once("classes/CChillers.php");
			$chill = new chillersDB;
			$allRow = $chill->GetMonthMatchs(2013,$prec+1);
			$z = $chill->dbCat->num_rows();
			if ( $z > 0 )
			{
				$z = $chill->dbCat->num_rows();
			}
			$chill->dbCat->next_record(); 
			
			for($i=0; $i<$z; $i++)
			{	
				echo "<tr  align=center><td>&nbsp;". $chill->dbCat->Record["c_date"] . "</td><td>&nbsp;&nbsp; " . substr($chill->dbCat->Record["c_hrs"],0,5) . "</td><td>". $chill->dbCat->Record["c_glace"] . "</td><td> 
				Chillers [" . $chill->dbCat->Record["c_chillersBut"] . "]</td><td>&nbsp;&nbsp;" .  $chill->dbCat->Record["c_visiteur"] . " [" . $chill->dbCat->Record["c_visiteurBut"]  .   "]</td></tr>";
				$chill->dbCat->next_record();
			}
		?>
		</TABLE>	

</div>		

<div class="tabComments">
		<table width="365" height="434" border="0">							 
		<tr valign="top">
			<td > 
			<div class="tabCommentsScroll">
			<table cellpadding=0 cellspacing=0 valign="top">				
			<?php
				require_once("classes/CChillers.php");
				$chill = new chillersDB;
				$allRow = $chill->DisplayComments(1);
				$chill->dbCat->next_record(); 
				$z = $chill->dbCat->num_rows();
				for($i=0; $i<$z; $i++)
				{	
					echo "<tr valign=top><td valign=top><h1><font color=#FFFFFF>". $chill->dbCat->Record["c_name"] . "</font></h1></td><tr>";
					echo "<tr valign=top><td valign=top><p>" . $chill->dbCat->Record["c_comment"] . "</p></td><tr>";
			
					$chill->dbCat->next_record();
				}
			?>			
			</table>
			</div>
			</td>
		</tr>
		<tr height="15">
		<td width="370" valign="top">
				<form style="margin: 0" name="AddComments" action="index.php?action=AddComment" method="post">
				<table><tr><td>Nom : <input name="Nom" type="text" size="40"></td></tr><tr><td><textarea name="ChillersComment" cols="40" rows="2"></textarea></td></tr>
				<tr>
					<td><input name="btnCmd" type="submit" value="Commentez!"></form>
				</td></tr></table>			
		</td>
		</tr>		
		<tr valign="top">
		<td width="370">
		<script src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script>
			new TWTR.Widget({
			version: 2,
			type: 'profile',
			rpp: 2,
			interval: 30000,
			width: '355',
			height: '100',
			theme: {
			shell: {
			background: '#F3BD01',
			color: '#000000'
			},
			tweets: {
			background: '#000000',
			color: '#FFFFFF', 
			links: '#F3BD01'
			}
			},
			features: {
			scrollbar: false,
			loop: false,
			live: false,
			hashtags: true,
			timestamp: true,
			avatars: false,
			behavior: 'all'
			}
			}).render().setUser('ChillersHockey').start();
		</script>
		</tr></td>
		</table>

</div>
<div class="tabPlayers">

	<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
			<tr class="tabHeader" WIDTH=449><td WIDTH=1></td><td WIDTH=179>Nom</td><td WIDTH=50>PJ</td><td WIDTH=50>Buts</td><td WIDTH=50>Ass</td><td WIDTH=50>PTS</td><td WIDTH=50>Pun</td></tr>
			<?php
				require_once("classes/CChillers.php");
				$chill = new chillersDB;
				$allRow = $chill->GetAllChillersExceptG(2012);
				$chill->dbCat->next_record(); 
				$z = $chill->dbCat->num_rows();
				for($i=0; $i<$z; $i++)
				{	
					echo "<tr><td class=leftAling>&nbsp;&nbsp;&nbsp;#" . $chill->dbCat->Record["j_number"] . "<td class=leftAling>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?id=" .  $chill->dbCat->Record["id"]  . ">" . $chill->dbCat->Record["j_name"] . "</a></td><td>". $chill->dbCat->Record["j_pj"] . "</td><td>" . 
					$chill->dbCat->Record["j_but"] . "</td><td>" . $chill->dbCat->Record["j_ass"] . "</td><td  class=ptsBack>" . $chill->dbCat->Record["j_pts"] . "</td><td>" . 
					$chill->dbCat->Record["j_minutesPun"] . "</td></tr>";
					$chill->dbCat->next_record();
				}
			?>
			<tr class="tabHeader"><td></td><td WIDTH=179>Nom</td><td WIDTH=50>PJ</td><td WIDTH=50>Buts</td><td WIDTH=50>Ass</td><td colspan="2" width="170" align="center">Moyenne</td></tr>
			<?php
				$allRow = $chill->GetGoaler(2012);
				$chill->dbCat->next_record(); 
				$z = $chill->dbCat->num_rows();
				for($i=0; $i<$z; $i++)
				{
					$moyen = 0;
					if ( $chill->dbCat->Record["j_pj"] != 0 )
					{
						$moyen = $chill->dbCat->Record["j_but"] /  $chill->dbCat->Record["j_pj"];
					}
						
					echo "<tr><td class=leftAling>&nbsp;&nbsp;&nbsp;#" . $chill->dbCat->Record["j_number"] . "<td class=leftAling>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?id=" .  $chill->dbCat->Record["id"]  . ">" . $chill->dbCat->Record["j_name"] . "</a></td><td>". $chill->dbCat->Record["j_pj"] . "</td><td>" . 
					
					$chill->dbCat->Record["j_but"] . "</td><td>".  $chill->dbCat->Record["j_ass"] . "</td><td colspan=2 align=center>" . round($moyen,3) . "</td></tr>";
					$chill->dbCat->next_record();
				}
			
			?>
			</TABLE>
		
</div>	
<div class="stats">
	<?php
				require_once("classes/CChillers.php");
				$Stats = new chillersDB;
		?>
		<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
		<tr class="tabHeader" valign="top"><td width="70">Victoires</td><td width="70">Défaites</td><td width="70">Nulles</td>
		<td width="70">Buts Pour </td><td width="70">Buts Contre</td><td width="99">%</td></tr>
		<?php
		$vic = $Stats->GetNbVictoires();
		$def = $Stats->GetNbDefaites();
		$null = $Stats->GetNbNulls(); 
		$perc = 0;
		if ( ($vic + $def + $null) > 0 ) 
		{
			$perc = $vic / ($vic + $def) * 1000;
		}
		
		if ( $perc <= 1000 ) 
		{
			$perc = "." + $perc;
		}
		?>
		<tr><td><?php echo $vic;  ?></td><td><?php echo $def;  ?></td><td><?php echo $null; ?></td>
		<td><?php echo $Stats->GetNbButsPour();  ?></td><td><?php echo $Stats->GetNbButsContre();  ?></td><td><?php echo $perc;  ?></td></tr>
		
		</table>
		
		
</div>			
	
<!-- End ImageReady Slices -->
</BODY>
</HTML>