<?php

	$url = "http://localhost/personomicon";
	$requests = 200;
	
	echo "<table>";
	
	for ($l = 0; $l < $requests; $l++) {
		
		//$date = new DateTime();
		//echo "<tr><td>" . $date->getTimestamp();		
		
		$contents =  file_get_contents($url);		
		
		//$date = new DateTime();
		//echo "<td>" . $date->getTimestamp() . "</tr>";		
		
		if (substr_count($contents, "error") > 0) {
			echo "<tr><td>ERROR: " . $l . "<td>" . $contents . "</tr>";
		}	
	}
	
	echo "<tr><td colspan=2>Test complete</tr>";
		
	echo "</table>";

?>