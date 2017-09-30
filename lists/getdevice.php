<?php

include ('device.php');

getEnvironment($devices);

function getEnvironment($devices) {
	
	$location_select = rand(0, count($devices)-1);
	$location = $devices[$location_select];
	echo "Loc Sel: " . $location_select . " (" . $location[0] . ")";
	
	var_dump($location);
	
	echo count($location[0]);
	$device_select = rand(0, count($location[1])-1);
	$device = $location[$device_select];
	echo "<br/>Dev Sec: " . $device_select . " (" . $device[0] . ")";
	
	//echo $device_select;
	
	//return [$location, $device, $os, $browser];
	
}

?>