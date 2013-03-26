<?php
	class connection {
		var $Host     = "127.0.0.1"; // Hostname of our MySQL server.
		var $Database = "XXXXX"; // Hidden for github
		var $User     = "XXXXX"; // Hidden for github
		var $Password = "XXXXX"; // Hidden for github
		
		var $Link_ID  = 0;  // Result of mysql_connect().
		var $Query_ID = 0;  // Result of most recent mysql_query().
		var $Record   = array();  // current mysql_fetch_array()-result.
		var $Row;           // current row number.
		
		var $Errno    = 0;  // error state of query...
		var $Error    = "";
		
		## halt() start ##
		
		function halt($msg) {
			printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
			printf("<b>MySQL Error</b>: %s (%s)<br>\n",
				$this->Errno,
				$this->Error);
			die("Session halted.");
		}
		
		## halt() end ##
		
		## connect() start ##
		
		function connect() {
			if ( 0 == $this->Link_ID ) {
				$this->Link_ID=mysql_connect($this->Host, $this->User, $this->Password);
				if (!$this->Link_ID) {
					$this->halt("Link-ID == false, connect failed");
				}
			  	if (!mysql_query(sprintf("use %s",$this->Database),$this->Link_ID)) {
					$this->halt("cannot use database ".$this->Database);
			  	}
			}
		}
		
		## connect() end ##
		
		## query() start ##
		
		function query($Query_String) {
			$this->connect();

			$this->Query_ID = mysql_query($Query_String,$this->Link_ID);
			$this->Row   = 0;
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();
			if (!$this->Query_ID) {
				$this->halt("Invalid SQL: ".$Query_String);
			}
			
			return $this->Query_ID;
		}
		
		## query() end ##
		
		## next_query() start ##
			
		function next_record() {
		    if ( $this->num_rows() > 0 )
			{
				$this->Record = mysql_fetch_array($this->Query_ID);
				$this->Row   += 1;
				$this->Errno = mysql_errno();
				$this->Error = mysql_error();
				
				$stat = is_array($this->Record);
				if (!$stat) {
					mysql_free_result($this->Query_ID);
					$this->Query_ID = 0;
				}
				return $stat;
			}
			
		}
		
		## next_query() end ##
		
		## seek() start ##
		
		function seek($pos) {
			$status = mysql_data_seek($this->Query_ID, $pos);
			if ($status)
				$this->Row = $pos;
			return;
		}
		
		function getAt($pos,$champ) {
			$var = mysql_result($this->Query_ID,$pos,$champ);
			return $var;
		}
		
		## seek() end ##
		
		function num_rows() {
			return mysql_num_rows($this->Query_ID);
		}
		
		function num_fields() {
			return mysql_num_fields($this->Query_ID);
		}
		
		function f($Name) {
			return $this->Record[$Name];
		}
		
		function p($Name) {
			print $this->Record[$Name];
		}
		
		function affected_rows() {
			return @mysql_affected_rows($this->Link_ID);
		}

	}
?>