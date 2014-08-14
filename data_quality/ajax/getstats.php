<?php
error_reporting(1);   
   if (isset($_POST['table1']) === true && empty($_POST['table1']) === false
   && isset($_POST['dt1']) === true && empty($_POST['dt1']) === false
   && isset($_POST['dt2']) === true && empty($_POST['dt2']) === false) {
   	require '../../connect.php';
   	$link = connect('linux');
   	$table1 = $_POST['table1'];
   	
   	if ($table1 == 'daily') {  // logic1 
   		$qry =  mysql_query(" select date(date) dt, count(distinct symbol) symbols from 1day_data 
   		where date(date) >= '" .$_POST['dt1']. "' 
   		and date(date) <= '" .$_POST['dt2']. "' 
   		group by 1;", $link); 
	}
	if ($table1 == '30mins') {  // logic1 
   		$qry =  mysql_query(" select date(date) dt, count(distinct symbol) symbols from 30mins_data 
   		where date(date) >= '" .$_POST['dt1']. "' 
   		and date(date) <= '" .$_POST['dt2']. "'
   		group by 1;", $link); 
	}
	if ($table1 == '5mins') {  // logic1 
   		$qry =  mysql_query(" select date(date) dt, count(distinct symbol) symbols from 5mins_data 
   		where date(date) >= '" .$_POST['dt1']. "' 
   		and date(date) <= '" .$_POST['dt2']. "'
   		group by 1;", $link); 
	}
	if ($table1 == 'sec') {  // logic1 
   		$qry =  mysql_query(" select date(date) dt, count(distinct symbol) symbols from data 
   		where date(date) >= '" .$_POST['dt1']. "' 
   		and date(date) <= '" .$_POST['dt2']. "'
   		group by 1;", $link); 
	}
   		$result = array();
   		while($record = mysql_fetch_assoc($qry)) {
   			$result[] = $record;
   		}
   				
   	$string = " 
   	<p align= left >
   		<table class='table table-striped table-hover'>
   		<tbody> 
   		<tr class= 'info' > 
   		<th>Date</th>
   		<th>Unique Symbols</th>
   		</tr>";
   	foreach($result as $record1) {
   		$string .= "<tr><td>" . $record1['dt'] . "</td><td>". $record1['symbols'] ."</td>";}
   	$string .= "</tr></tbody></table>";
	echo (mysql_num_rows($qry) !== 0) ? $string : 'no record found';
}	
?>