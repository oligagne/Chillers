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

?>
</html>