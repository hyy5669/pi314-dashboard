<?php
function connect($datasource){
	switch ($datasource) {
		case 'linux':
			$link = mysql_connect('10.8.0.23', 'root', '314159'); 
			mysql_select_db("pi314"); 
			break;			
		case 'aws':
			$link = mysql_connect('pi314.cn6qs5axgapc.us-west-1.rds.amazonaws.com', 'pi314admin', 'pi314159'); 
			mysql_select_db("pi314"); 
			break;
		default:
			throw new Exception("Connection Failure: not recoginzed $datasource");
	}	
	if (!$link) {
		die("Could not connect to $datasource: ". mysql_error());
	}
	return $link;
}
?>