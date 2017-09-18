<?php

function displayPersonaDemographics() {

	$details = getUserDetails();
	$title = $details[5];
		
	echo "<div class='section'>";
	
		// Picture / Name
		echo "<div class='line'><div class='image'><img src='" . $details[4] . "' align=center /></div><div class='name'>" . $title . " " . $details[1] . " " . $details[2] . "</div></div>";

	echo "</div>";
	
	echo "<div class='rule'></div>";
		
	echo "<div class='section'>";
	
		// DOB / Age
		$dob_age = generateDOBAge();
		echo "<div class='line'><div class='linetitle'>Born</div><div class='linecontent'>" . $dob_age[0] . " (" . $dob_age[1] . ")</div></div>";
		
		$personaAge = $dob_age[1];
		
		// Nationality
		echo "<div class='line'><div class='linetitle'>Nationality</div><div class='linecontent'><img src='images/flags/" . strtolower($details[3]) . ".png' style='margin-top: -5px;'> " . getNationality($details[3]) . "</div></div>";	
	
	echo "</div>";
	
	echo "<div class='section'>";
		// Marital Status
		$marital_status = getMaritalStatus($dob_age[1], $details[5]);
		if ($marital_status[0] == "Married") {
			$marital_text = $marital_status[0] . " for " . $marital_status[1] . " year(s)";
		} else {
			$marital_text = $marital_status[0];
		}
		echo "<div class='line'><div class='linetitle'>Marital Status</div><div class='linecontent'>" . $marital_text . "</div></div>";
		
		// Children
		$children = getChildren($marital_status[1]);
		if ($children[0] == 0) {
			$kids_text = "None";
		} elseif ($children[0] == 1) {
			$kids_text = "1 child; " . $children[1];
		} else {
			$kids_text = $children[0] . " children; " . $children[1];
		}
		echo "<div class='line'><div class='linetitle'>Children</div><div class='linecontent'>" . $kids_text . "</div></div>";
		
		// Education
		$education = getEducation($title);
		echo "<div class='line'><div class='linetitle'>Education</div><div class='linecontent'>" . $education[0];
		if ($education[1] != "") {
			echo ", " . $education[1];
		}
		echo "</div></div>";

		if (rand(1, 100) > 92) {
			// Criminal Record
			$crimes = getLinesFromFile('crimes', rand(1, 3));
			echo "<div class='line'><div class='linetitle'>Crimes</div><div class='linecontent'>" . $crimes . "</div></div>";
		}
		
	echo "</div>";
		
	echo "<div class='section'>";
	
		//Traits
		$traits = getTraits();
		echo "<div class='line'><div class='linetitle'>Traits</div><div class='linecontent'>" . $traits . "</div></div>";

		//Values
		$values = getvalues();
		echo "<div class='line'><div class='linetitle'>Values</div><div class='linecontent'>" . $values . "</div></div>";
		
		// Likes
		$values = getLinesFromFile('likes', 3);
		echo "<div class='line'><div class='linetitle'>Likes</div><div class='linecontent'>" . $values . "</div></div>";
		
		// Dislikes
		$values = getLinesFromFile('dislikes', 3);
		echo "<div class='line'><div class='linetitle'>Dislikes</div><div class='linecontent'>" . $values . "</div></div>";

		// Phobias
		$values = getPhobia(rand(1,4));
		echo "<div class='line'><div class='linetitle'>Phobias</div><div class='linecontent'>" . $values . "</div></div>";
		
	echo "</div>";
	
	return $personaAge;
	
}

function displayPersonaProfile($age) {
	
	echo "<div class='section'>";
	
		echo "<div class='line'><div class='linetitle'>Age</div><div class='linecontent'>" . $age . "</div></div>";

	echo "</div>";
	
}

function generateForeName() {
	
	# Get Forename
	$forenames = file('lists/forenames.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($forenames));
	$forename = trim(ucfirst(strtolower($forenames[$index])));

	return $forename;
	
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

function getChildren($length_of_marriage) {
	
	$max_kids = 4;
	
	if ($length_of_marriage < $max_kids) {
		$max = $length_of_marriage - 2;
	} else {
		$max = $max_kids;
	}
	
	$numKids = rand(0, $max);
	$kid_details = "";
	$max_age = $length_of_marriage;
	for ($k = 0; $k < $numKids; $k++) {
		$kid_age = 0;
		$name = generateForeName();
		$min_age = $max_age - 4;
		$max_age = $max_age - 1;
		while ($kid_age <= 0) {
			$kid_age = rand($min_age, $max_age);
		}
		$kid_details = $kid_details . ucfirst($name) . " (" . $kid_age . "), ";
		$max_age = $kid_age;
		
	}
	
	return [$numKids, substr($kid_details, 0, strlen($kid_details)-2)];

}

function getEducation($title) {
	
	$level = "";
	$course = "";
	
	if ($title != "Dr" || $title != "Prof") {
	
		$choice = rand(0, 2);
		switch ($choice) {
			case 0:
				$level = "Secondary School";
				break;
			case 1:
				$level = "College";
				$course = getCourse();
				break;
			case 2:
				$level = "Undergraduate Degree";
				$course = getCourse();
				break;
		}
	
	} else {
		$level = "Postgraduate Degree";
		//$course = getCourse();
		$course = getLinesFromFile('courses', 1);
	}
	
	return [$level, $course];
	
}

function getCourse() {

	$courses = file('lists/courses.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($courses)-1);
	$course = trim(ucwords(strtolower($courses[$index])));
	
	return $course;
	
}

function getTraits() {
	
	$text = "";
	$traits = file('lists/traits.txt');
	for ($t = 0; $t < 3; $t++) {
		$word = trim($traits[rand(0, count($traits)-1)]);
		$text = $text . "<a href='http://www.dictionary.com/browse/" . lcfirst($word) . "?s=t' target='_blank' title='View definition'>" . $word . "</a>, ";
	}
	
	return substr($text, 0, strlen($text)-2);
	
}

function getValues() {
	
	$text = "";
	$values = file('lists/values.txt');
	for ($t = 0; $t < 3; $t++) {
		$word = trim($values[rand(0, count($values)-1)]);
		$text = $text . "<a href='http://www.dictionary.com/browse/" . lcfirst($word) . "?s=t' target='_blank' title='View definition'>" . $word . "</a>, ";
	}
	
	return substr($text, 0, strlen($text)-2);
	
}

function getLinesFromFile($file, $rows) {
	
	$text = "";
	$values = file("lists/" . $file . ".txt");
	for ($t = 0; $t < $rows; $t++) {
		$word = ucfirst(trim($values[rand(0, count($values)-1)]));
		if (substr($word, -1, 1) == ".") {
			$word = substr($word, 0, strlen($word)-1);
		}
		$text = $text . $word . ", ";
	}
	
	$text = substr($text, 0, strlen($text)-2); // Remove trailing comma
	
	return $text;	
	
}

function getPhobia($count) {
	
	$text = "";
	$phobias = file('lists/phobias.txt');
	for ($t = 0; $t < $count; $t++) {
		$phobia = trim($phobias[rand(0, count($phobias)-1)]);
		$details = explode("- ", $phobia);
		$phobiaName = $details[0];
		$phobiaNames = explode(" or ", $phobiaName);
		$phobiaName = $phobiaNames[0];
		$phobiaDesc = $details[1];
		$text = $text . "<span title='" . $phobiaDesc . "'>" . $phobiaName . "</span>, ";
	}
	
	return substr($text, 0, strlen($text)-2);	
	
}

?>