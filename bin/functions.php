<?php

function displayPersona() {

	$details = getUserDetails();
	
	echo "<img src='" . $details[4] . "'></img><p>";
	echo "<font face='Georgia' size=6>" . $details[5] . " " . $details[1] . " " . $details[2] . "</font><p>";
	//echo "<font face='Georgia' size=6>" . generateName() . "</font><p>";
	
	// DOB / Age
	$dob_age = generateDOBAge();
	echo "<font face='Georgia' size=4>Born: " . $dob_age[0] . " (" . $dob_age[1] . ")</font><p>";
	
	// Nationality
	echo "<img src='images/flags/" . strtolower($details[3]) . ".png' style='padding-top: 0.3em;'> <font face='Georgia' size=4 style='padding-top: 0em;'>" . getNationality($details[3]) . "</font><p>";	
	
	// Marital Status
	$marital_status = getMaritalStatus($dob_age[1], $details[5]);
	if ($marital_status[0] == "Married") {
		$marital_text = $marital_status[0] . " for " . $marital_status[1] . " year(s)";
	} else {
		$marital_text = $marital_status[0];
	}
	echo "<font face='Georgia' size=4>" . $marital_text . "</font><p>";
	
	// Children
	$children = getChildren($marital_status[1]);
	if ($children == 0) {
		$kids_text = "";
	} elseif ($children == 1) {
		$kids_text = "1 child";
	} else {
		$kids_text = $children . " children";
	}
	echo "<font face='Georgia' size=4>" . $kids_text . "</font><p>";
	
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
	
	return [$birth_date, $age];
	
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
	
	$json = json_decode(file_get_contents($url));
	
	$gender = $json->results[0]->gender;
	$forename = ucwords($json->results[0]->name->first);
	$surname = ucwords($json->results[0]->name->last);
	$nationality = $json->results[0]->nat;
	$image = $json->results[0]->picture->large;	
	$title = ucwords($json->results[0]->name->title);	
	
	return [$gender, $forename, $surname, $nationality, $image, $title];
	
}

function getNationality($prefix) {
	
	$nationality = "";
	$countries = file('lists/countries.txt');
	foreach ($countries as $country) {
		$elements = explode(",", $country);
		if (trim($elements[2]) == $prefix) {
			$nationality = $elements[1];
		}
	}
	if ($nationality == "") {
		$nationality = "British";
	}
	
	return $nationality;
	
}

function getMaritalStatus($age, $title) {
	
	// Likelihood of being married increases from 0.2 at age 22 to 0.9 at age 40, then constant from then on.
	
	if ($title == "Ms" || $title == "Miss"  || $title == "Mademoiselle") {
		$status = "Single";
	} elseif ($title == "Mrs" || $title == "Madame") {
		$status = "Married"; 
	} else {
		
		if ($age > 40) {
			$marital_chance = 0.9;
		} else {
			$marital_chance = ((($age-22)/(70-22)) * 0.7) + 0.2;
		}
		
		if (rand(0, 1) < $marital_chance) {
			$status = "Married";
		} else {
			$status = "Single";
		}
	}
	
	if ($status == "Married") {
		if ($age > 40) {
			$marital_chance = 0.9;
		} else {
			$marital_chance = ((($age-22)/48) * 0.7) + 0.2;
		}
		$duration = rand(1, ($age-22));
	} else {
		$duration = 0;
	}
	
	return [$status, $duration];
	
}

function getChildren($duration) {
	
	$max_kids = 4;
	
	if ($duration < $max_kids) {
		$max = $duration;
	} else {
		$max = $max_kids;
	}
	
	return rand(0, $max);
	
	
	
}


?>