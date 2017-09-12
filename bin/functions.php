<?php

function displayPersona() {

	$details = getUserDetails();
	
	echo "<img src='" . $details[4] . "'></img><p>";
	echo "<font face='Georgia' size=6>" . $details[5] . " " . $details[1] . " " . $details[2] . "</font><p>";
	//echo "<font face='Georgia' size=6>" . generateName() . "</font><p>";
	echo "<font face='Georgia' size=4>Born: " . generateDOBAge() . "</font><p>";
	echo "<font face='Georgia' size=4>Country: " . getCountryName($details[3]) . "</font><p>";	

}

function generateName() {
	
	
	# Get Forename
	$forenames = file('lists/forenames.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($forenames));
	$forename = trim(ucfirst(strtolower($forenames[$index])));
	
	# Get Surname
	$surnames = file('lists/surnames.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($surnames));
	$surname = trim($surnames[$index]);	

	return $forename . " " . $surname;
	
}

function generateDOBAge() {
	
	$min = strtotime("70 years ago");
	$max = strtotime("22 years ago");

	$rand_time = mt_rand($min, $max);

	$birth_date = date('d/m/Y', $rand_time);
	$age = calculateAge($birth_date);
	
	return $birth_date . " (" . $age . ")";
	
}

function calculateAge($dob) {

  //explode the date to get month, day and year
  $birthDate = explode("/", $dob);
  //get age from date or birthdate
  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
    ? ((date("Y") - $birthDate[2]) - 1)
    : (date("Y") - $birthDate[2]));
  
  return $age;
	
}

function getUserDetails() {
	
	// This function will extract the following random user details
	// 1. Name
	// 2. headshot image
	// 3. Nationality
	
	$url = "https://randomuser.me/api/";
	
	//echo file_get_contents($url);
	//var_dump(json_decode(file_get_contents($url)));
	
	$json = json_decode(file_get_contents($url));
	
	$gender = $json->results[0]->gender;
	$forename = ucwords($json->results[0]->name->first);
	$surname = ucwords($json->results[0]->name->last);
	$nationality = $json->results[0]->nat;
	$image = $json->results[0]->picture->large;	
	$title = ucwords($json->results[0]->name->title);	
	
	return [$gender, $forename, $surname, $nationality, $image, $title];
	
}

function getCountryName($prefix) {
	
	$country_name = "";
	$countries = file('lists/countries.txt');
	foreach ($countries as $country) {
		$elements = explode(",", $country);
		if (trim($elements[1]) == $prefix) {
			$country_name = $elements[0];
		}
	}
	
	return $country_name;
	
}


?>