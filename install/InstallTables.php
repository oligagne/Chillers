<?php
// Make a MySQL Connection
mysql_connect("localhost", "_user_", "_pwd_") or die(mysql_error());
mysql_select_db("_db_") or die(mysql_error());

// Create a MySQL table in the selected database
mysql_query("CREATE TABLE `c_players` (
  `id` int(11) NOT NULL auto_increment,
  `j_name` varchar(30) default NULL,
  `j_position` varchar(15) default NULL,
  `j_number` int(11) default NULL,
  `j_pj` int(11) default NULL,
  `j_but` int(11) default NULL,
  `j_ass` int(11) default NULL,
  `j_pts` int(11) default NULL,
  `j_minutesPun` int(11) default NULL,
  `j_link` varchar(50) default NULL,
  `j_phone` varchar(12) default NULL,
  `j_annee` varchar(4) default NULL,
  `j_actif` tinyint(1) default NULL,
  `j_desc` text,
  PRIMARY KEY  (`id`))");

echo "Table c_joueurs!";

// Create a MySQL table in the selected database
mysql_query("CREATE TABLE `c_calender` (
  `id` int(11) NOT NULL auto_increment,
  `c_date` date default NULL,
  `c_hrs` time default NULL,
  `c_glace` char(2) default NULL,
  `c_visiteur` varchar(20) default NULL,
  `c_chillersBut` int(11) default NULL,
  `c_visiteurBut` int(11) default NULL,
  `c_victoire` int(11) default NULL,
  `c_actif` tinyint(1) default NULL,
  `c_desc` text,
PRIMARY KEY  (`id`)
)");
 
echo "Table c_calender!";

// Create a MySQL table in the selected database
mysql_query("CREATE TABLE `c_stats` (
  `id_stats` int(11) NOT NULL auto_increment,
  `s_idMatch` int(11) default NULL,
  `s_idJoueurs` int(11) default NULL,
  `s_pj` int(11) default NULL,
  `s_but` int(11) default NULL,
  `s_ass` int(11) default NULL,
  `s_pts` int(11) default NULL,
  `s_minutesPun` int(11) default NULL,
PRIMARY KEY  (`id_stats`)
)")
 or die(mysql_error());  

echo "Table c_Stats!";

// Create a MySQL table in the selected database
mysql_query("CREATE TABLE `c_comments` (
  `id` int(11) NOT NULL auto_increment,
  `c_date` datetime default NULL,
  `c_name` varchar(30) default NULL,
  `c_comment` text,
  `c_display` tinyint(1) default NULL,
  `c_link` varchar(75) default NULL,
  `c_desc` text,
PRIMARY KEY  (`id`)
)")
 or die(mysql_error());  
 
echo "Table c_comment!";


mysql_query("CREATE TABLE `c_stars` (
`id` int(11) NOT NULL auto_increment,
`c_calenderId` int(11) default NULL,
`c_rank` int(11) default NULL,
`c_name` varchar(15) default NULL,
`c_playerId` int(11) default NULL,
`c_comment` varchar(50) default NULL,
`c_link` varchar(75) default NULL,
`c_desc` text,
PRIMARY KEY  (`id`)
)")
 or die(mysql_error());  
 
echo "Table c_stars!";

?>