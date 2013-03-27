<HTML>
<HEAD>
<TITLE>Chillers</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
<link href="chillers.css" rel="stylesheet" type="text/css">
</HEAD>
<body style="overflow:auto">
<?php
	//Redirect to mobile website.
	include 'Mobile_Detect.php';
	
	$detect = new Mobile_Detect();
	if ($detect->isMobile()) // Any mobile device.
	{		
		header('Location:http://www.chillershockey.org/mobile/');
	}
	
	require_once("classes/CChillers.php");
	$chillers = new chillersDB;
	
	//section to add comments
	if ( isset($_GET['action']) && $_GET['action'] == "AddComment") 
	{	
		$postedNews = $_REQUEST['ChillersComment'];
		$strNews = strtolower($postedNews);
		//spam bot protection. Sorry guys no more link here.
		$http = strtolower("http");
		$href = strtolower("href");		   
		if (  strstr($strNews,$http) == false  && strstr($strNews,$href) == false  )
		{
			$chillers->AddComment($_REQUEST['Nom'],$postedNews,"");
		}	
	} 
	//month variables for fame section
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
			$allRow = $chillers->FindStars();
			$nbStars = $chillers->dbCat->num_rows();
			if ( $nbStars > 0 )
			{
				$chillers->dbCat->next_record(); 
			}	
			echo "<TABLE>";
			for($i=0; $i<$nbStars; $i++)
			{	
				echo "<TR><TD valign=top><img src=images/star" . ($i+1) . ".gif><font size=2>     <b>" . $chillers->dbCat->Record["c_name"] . "</b>      " . $chillers->dbCat->Record["c_comment"] . "</font></TD></TR>";
				$chillers->dbCat->next_record();
			}
			echo "</TABLE>"
		?>
	</div>		
</div>		

<div class="tabMatchs">
	<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
	<TR class="tabHeader">
		<TD width="79">Date </TD><TD width="65"> Heure</TD><TD width="35">Glace</TD><TD width="135">Local</TD><TD width="135">Visiteur</TD>
	</TR>
	<TR>
		<TD width="79"> </TD><TD width="65"> </TD><TD width="35"></TD><TD width="135"></TD><TD width="135"></TD>
	</TR>
	<TR>
		<TD width="79"> </TD><TD width="65"> </TD><TD width="35"></TD><TD width="135"></TD><TD width="135"></TD>
	</TR>	
	<?php
		$allRow = $chillers->GetMonthMatchs(2013,$prec+1);
		$nbMatchsMonth = $chillers->dbCat->num_rows();
		if ( $nbMatchsMonth > 0 )
		{
			$nbMatchsMonth = $chillers->dbCat->num_rows();
		}
		$chillers->dbCat->next_record(); 
		
		for($i=0; $i<$nbMatchsMonth; $i++)
		{	
			echo "<TR  align=center><TD>&nbsp;". $chillers->dbCat->Record["c_date"] . "</TD><TD>&nbsp;&nbsp; " . substr($chillers->dbCat->Record["c_hrs"],0,5) . "</TD><TD>". $chillers->dbCat->Record["c_glace"] . "</TD><TD> 
			Chillers [" . $chillers->dbCat->Record["c_chillersBut"] . "]</TD><TD>&nbsp;&nbsp;" .  $chillers->dbCat->Record["c_visiteur"] . " [" . $chillers->dbCat->Record["c_visiteurBut"]  .   "]</TD></TR>";
			$chillers->dbCat->next_record();
		}
	?>
	</TABLE>	

</div>		
<div class="tabComments">
	<TABLE width="365" height="434" border="0">							 
	<TR valign="top">
		<TD > 
			<DIV class="tabCommentsScroll">
			<TABLE cellpadding=0 cellspacing=0 valign="top">				
			<?php
				$allRow = $chillers->DisplayComments(1);
				$chillers->dbCat->next_record(); 
				$nbComments = $chillers->dbCat->num_rows();
				for($i=0; $i<$nbComments; $i++)
				{	
					echo "<TR valign=top><TD valign=top><h1><font color=#FFFFFF>". $chillers->dbCat->Record["c_name"] . "</font></h1></TD><TR>";
					echo "<TR valign=top><TD valign=top><p>" . $chillers->dbCat->Record["c_comment"] . "</p></TD><TR>";
			
					$chillers->dbCat->next_record();
				}
			?>			
			</TABLE>
			</DIV>
		</TD>
	</TR>
	<TR height="15">
		<TD width="370" valign="top">
			<form style="margin: 0" name="AddComments" action="index.php?action=AddComment" method="post">
			<TABLE>
				<TR>
					<TD>Nom : <input name="Nom" type="text" size="40"></TD></TR><TR><TD><textarea name="ChillersComment" cols="40" rows="2"></textarea></TD>
				</TR>
				<TR>
					<TD><input name="btnCmd" type="submit" value="Commentez!"></form></TD>
				</TR>
			</TABLE>			
		</TD>
	</TR>		
	<TR valign="top">
		<TD width="370">
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
		</TD>
	</TR>
	</TABLE>
</div>

<div class="tabPlayers">
	<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
		<TR class="tabHeader" WIDTH=449>
			<TD WIDTH=1></TD><TD WIDTH=179>Nom</TD><TD WIDTH=50>PJ</TD><TD WIDTH=50>Buts</TD><TD WIDTH=50>Ass</TD><TD WIDTH=50>PTS</TD><TD WIDTH=50>Pun</TD>
		</TR>
		<?php
			$allRow = $chillers->GetAllChillersExceptG(2012);
			$chillers->dbCat->next_record(); 
			$nbPlayers = $chillers->dbCat->num_rows();
			for($i=0; $i<$nbPlayers; $i++)
			{	
				echo "<TR><TD class=leftAling>&nbsp;&nbsp;&nbsp;#" . $chillers->dbCat->Record["j_number"] . "<TD class=leftAling>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?id=" .  $chillers->dbCat->Record["id"]  . ">" . $chillers->dbCat->Record["j_name"] . "</a></TD><TD>". $chillers->dbCat->Record["j_pj"] . "</TD><TD>" . 
				$chillers->dbCat->Record["j_but"] . "</TD><TD>" . $chillers->dbCat->Record["j_ass"] . "</TD><TD  class=ptsBack>" . $chillers->dbCat->Record["j_pts"] . "</TD><TD>" . 
				$chillers->dbCat->Record["j_minutesPun"] . "</TD></TR>";
				$chillers->dbCat->next_record();
			}
		?>
		<TR class="tabHeader">
			<TD></TD><TD WIDTH=179>Nom</TD><TD WIDTH=50>PJ</TD><TD WIDTH=50>Buts</TD><TD WIDTH=50>Ass</TD><TD colspan="2" width="170" align="center">Moyenne</TD>
		</TR>
		<?php
			$allRow = $chillers->GetGoaler(2012);
			$chillers->dbCat->next_record(); 
			$nbGoaler = $chillers->dbCat->num_rows(); //hope only one :)
			for($i=0; $i<$nbGoaler; $i++)
			{
				$moyen = 0;
				if ( $chillers->dbCat->Record["j_pj"] != 0 )
				{
					$moyen = $chillers->dbCat->Record["j_but"] /  $chillers->dbCat->Record["j_pj"];
				}
					
				echo "<TR><TD class=leftAling>&nbsp;&nbsp;&nbsp;#" . $chillers->dbCat->Record["j_number"] . "<TD class=leftAling>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=index.php?id=" .  $chillers->dbCat->Record["id"]  . ">" . $chillers->dbCat->Record["j_name"] . "</a></TD><TD>". $chillers->dbCat->Record["j_pj"] . "</TD><TD>" . 
				
				$chillers->dbCat->Record["j_but"] . "</TD><TD>".  $chillers->dbCat->Record["j_ass"] . "</TD><TD colspan=2 align=center>" . round($moyen,3) . "</TD></TR>";
				$chillers->dbCat->next_record();
			}			
		?>
	</TABLE>		
</div>	
<DIV class="stats">
	<TABLE border=0 bordercolor=#000000 cellpadding=0 cellspacing=0 class="tabChillers">
		<TR class="tabHeader" valign="top">
			<TD width="70">Victoires</TD><TD width="70">Défaites</TD><TD width="70">Nulles</TD>
			<TD width="70">Buts Pour </TD><TD width="70">Buts Contre</TD><TD width="99">%</TD>
		</TR>
		<?php
			$vic = $chillers->GetNbVictoires();
			$def = $chillers->GetNbDefaites();
			$null = $chillers->GetNbNulls(); 
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
		<TR>
			<TD><?php echo $vic;  ?></TD><TD><?php echo $def;  ?></TD><TD><?php echo $null; ?></TD>
			<TD><?php echo $chillers->GetNbButsPour();  ?></TD><TD><?php echo $chillers->GetNbButsContre();  ?></TD><TD><?php echo $perc;  ?></TD>
		</TR>	
	</TABLE>
</DIV>			
</BODY>