<?php

function displayPersonaDemographics() {

	$details = getUserDetails();
	$title = $details[5];
	$sentence = 0;
		
	echo "<div class='section'>";
	
		// Picture / Name
		echo "<div class='line'><div class='image'><img src='" . $details[4] . "' align=center /></div><div class='name'>" . $title . " " . $details[1] . " " . $details[2] . "</div></div>";

	echo "</div>";
	
	echo "<div class='rule'></div>";
		
	echo "<div class='section'>";
	
		// DOB / Age
		$dob_age = generateDOBAge($details[6]);
		echo "<div class='line'><div class='linetitle'>Born</div><div class='linecontent'>" . $dob_age[0] . " (" . $dob_age[1] . ")</div></div>";
		
		$personaAge = $dob_age[1];
		
		// Nationality
		echo "<div class='line'><div class='linetitle'>Nationality</div><div class='linecontent'><img src='images/flags/" . strtolower($details[3]) . ".png' style='margin-top: -5px;'> " . getNationality($details[3]) . "</div></div>";

		$geography = getGeography();
		
		$languages = getLanguages($details[3], $geography);
		echo "<div class='line'><div class='linetitle'>Languages</div><div class='linecontent'>" . $languages . "</div></div>";
		
	
	echo "</div>";
	
	echo "<div class='section'>";
		// Marital Status
		$marital_status = getMaritalStatus($dob_age[1], $details[5]);
		if ($marital_status[0] == "Married") {
			$marital_text = $marital_status[0] . " for " . $marital_status[1] . " year(s) to " . $marital_status[2];
		} else {
			$marital_text = $marital_status[0];
		}
		echo "<div class='line'><div class='linetitle'>Marital Status</div><div class='linecontent'>" . $marital_text . "</div></div>";
		
		// Children
		$children = getChildren($marital_status[1], $personaAge);
		if ($children[0] == 0) {
			$kids_text = "None";
		} elseif ($children[0] == 1) {
			$kids_text = "1 child; " . $children[1];
		} else {
			$kids_text = $children[0] . " children; " . $children[1];
		}
		echo "<div class='line'><div class='linetitle'>Children</div><div class='linecontent'>" . $kids_text . "</div></div>";
		
		// Education
		$education = getEducation($title, $personaAge);
		echo "<div class='line'><div class='linetitle'>Education</div><div class='linecontent'>" . $education[0];
		if ($education[1] != "") {
			echo ", " . $education[1];
		}
		echo "</div></div>";

		// Criminal Record
		$crime_text = "";
		if (rand(1, 100) > 92) {
			$crime_details = getCrime($personaAge);
			$crime_text = $crime_details[0];
			$sentence = $crime_details[1];
			echo "<div class='line'><div class='linetitle'><span title='Criminal Record'>Crimes</span></div><div class='linecontent'>" . $crime_text . "</div></div>";
		}
		
		
		
	echo "</div>";
		
	echo "<div class='section'>";
	
		//Traits
		$traits = getTraits('3');
		echo "<div class='line'><div class='linetitle'>Traits</div><div class='linecontent'>" . $traits . "</div></div>";

		//Values
		$values = getValues('3');
		echo "<div class='line'><div class='linetitle'>Values</div><div class='linecontent'>" . $values . "</div></div>";
		
		// Likes
		$values = getLinesFromFile('likes', 1);
		echo "<div class='line'><div class='linetitle'>Likes</div><div class='linecontent'>" . $values . "</div></div>";
		
		// Dislikes
		$values = getLinesFromFile('dislikes', 1);
		echo "<div class='line'><div class='linetitle'>Dislikes</div><div class='linecontent'>" . $values . "</div></div>";

		// Phobias
		$values = getPhobia(rand(1,4));
		echo "<div class='line'><div class='linetitle'>Phobias</div><div class='linecontent'>" . $values . 
		"</div></div>";

		// Illness
		if (rand(0, 20) == 20) {
			$values = getLinesFromFile('illnesses', 1);
			echo "<div class='line'><div class='linetitle'>Work Illness</div><div class='linecontent'>" . $values . 
		"</div></div>";
		}
		
	echo "</div>";
	
	echo "<div class='section'>";

		// Pets
		$have_pets = rand(0, 1);
		if ($have_pets == 1) {
			$details = getPet();
			echo "<div class='line'><div class='linetitle'>Pets</div><div class='linecontent'>" . $details . "</div></div>";
		}
		
		// Hobbies
		echo "<div class='line'><div class='linetitle'>Hobbies</div><div class='linecontent'>" . getLinesFromFile('hobbies', rand(1, 4)) . "</div></div>";

		// Social Media
		echo "<div class='line'><div class='linetitle'>Social Media</div><div class='linecontent'>" . getLinesFromFile('social', rand(1, 4)) . "</div></div>";
		
	echo "</div>";

	
	return [$personaAge, $education[2], $sentence, $geography];
	
}

function displayPersonaProfile($details) {
	
	$age = $details[0];
	$experience = $details[1];
	$sentence = $details[2];
	$geography = $details[3];
	
	echo "<div class='section'>";
	
		if ($sentence > 0) {
			$experience = $experience - $sentence;
			if ($experience <= 0) {
				$experience = rand(0, ceil($experience/3));
			}
		} 
		if ($experience <= 0) {
			$experience = 1;
		}
	
		// Experience
		echo "<div class='line'><div class='linetitle'>Experience</div><div class='linecontent'>" . $experience . " years</div></div>";
		
		// Company
		echo "<div class='line'><div class='linetitle'>Company</div><div class='linecontent'>" . getCompany() . "</div></div>";
		
		// Role
		$role = getRole($experience);
		echo "<div class='line'><div class='linetitle'>Seniority</div><div class='linecontent'>" . $role . "</div></div>";
		
		// Domain
		echo "<div class='line'><div class='linetitle'>Domain</div><div class='linecontent'>" . getLinesFromFile('domains', 1) . "</div></div>";
		
		// Domain Experience
		echo "<div class='line'><div class='linetitle'>Knowledge</div><div class='linecontent'>" . getDomainExperience($experience) . "</div></div>";
		
		// Worker Type
		$type = getWorkerType($experience, $role);
		echo "<div class='line'><div class='linetitle'><a href='https://www.forbes.com/sites/stevefaktor/2012/11/15/feature-the-9-corporate-personality-types-how-to-inspire-them-to-innovate/#49a9db872753' target='_blank' title='Open source article'>Employee Type</a></div><div class='linecontent'><a href='' title='" . $type[1] . "'>" . $type[0] . "</a></div></div>";

	echo "</div>";

	$office_details = getEnvironment();
	
	echo "<div class='section'>";
	
		// Geography
		echo "<div class='line'><div class='linetitle'>Geography</div><div class='linecontent'>" . $geography . "</div></div>";
		
		// Location
		echo "<div class='line'><div class='linetitle'>Location</div><div class='linecontent'>" . $office_details[0] . "</div></div>";
		
		// Device
		echo "<div class='line'><div class='linetitle'>Device</div><div class='linecontent'>" . $office_details[1] . " | " . $office_details[2] . "</div></div>";
		
		// Browser
		echo "<div class='line'><div class='linetitle'>Browser</div><div class='linecontent'>" . $office_details[3] . "</div></div>";
		
		// Assistive Tech
		$have = rand(0, 10);
		if ($have == 10) {
			$details = getLinesFromFile('assistive', 1);
			echo "<div class='line'><div class='linetitle'>Assistive Tech.</div><div class='linecontent'>" . $details . "</div></div>";
		}
		
		echo "<div class='line'><div class='linetitle'>Tech Savvy</div><div class='linecontent'>" . getLinesFromFile('expertise', 1) . "</div></div>";

	echo "</div>";

	echo "<div class='section'>";
	
		// Communication Styles
		echo "<div class='line'><div class='linetitle'><span title='Communication Style'>Comm. Style</a></div><div class='linecontent'>" . getLinesFromFile('commstyles',1) . "</div></div>";

		// Preferred Medium
		echo "<div class='line'><div class='linetitle'><span title='Preferred communication type'>Pref. Comm.</a></div><div class='linecontent'>" . getLinesFromFile('commtype',1) . "</div></div>";

		// Important Software Qualities
		echo "<div class='line'><div class='linetitle'><span title='Values these software qualities'>S/w Values</a></div><div class='linecontent'>" . getLinesFromFile('qualities',3) . "</div></div>";
		
	echo "</div>";
	
	echo "<div class='section'>";
	
		// Sense of Humour
		$values = getLinesFromFile('humour',1);
		echo "<div class='line'><div class='linetitle'>Humour</div><div class='linecontent'>" . $values . "</div></div>";
		
		// Cake
		$cake = getCake();
		echo "<div class='line'><div class='linetitle'>Brings cake</div><div class='linecontent'>" . $cake . "</div></div>";
	
	echo "</div>";
	
}

function generateForeName() {
	
	# Get Forename
	$forenames = file('lists/forenames.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($forenames)-1);
	$forename = trim(ucfirst(strtolower($forenames[$index])));

	return $forename;
	
}

function generateDOBAge($dob) {
	
	/*
	$min = strtotime("70 years ago");
	$max = strtotime("22 years ago");

	$rand_time = mt_rand($min, $max);

	$birth_date = date('d/m/Y', $rand_time);
	
	*/
	
	// Alternative, from randomuser.me API
	$dob_date_time = explode(" ", $dob);
	$dob = $dob_date_time[0];
	$dob_bits = explode("-", $dob);
	$birth_date = $dob_bits[2] . "/" . $dob_bits[1] . "/" . $dob_bits[0];
	
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
	$dob = $json->results[0]->dob;
	
	return [$gender, $forename, $surname, $nationality, $image, $title, $dob];
	
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
	
	$spouse = getSpouse($age);
	
	return [$status, $duration, $spouse];
	
}

function getSpouse($age) {
	
	$spouse_name = generateForeName();
	$spouse_age = rand($age-4, $age+4);
	
	return $spouse_name . " (" . $spouse_age . ")";
	
}

function getChildren($length_of_marriage, $parent_age) {
	
	$max_kids = 4;
	
	if ($length_of_marriage > 0) { // Married
		if ($length_of_marriage < $max_kids) {
			$max = $length_of_marriage - 2;
		} else {
			$max = $max_kids;
		}
	} elseif ($length_of_marriage <= 6 && $length_of_marriage > 0) {
		$max = 3;
	
	} else { // Not married
		if (rand(1, 10) > 7) {
			$max = $parent_age - 24;
			if ($max > $max_kids) {
				$max = $max_kids;
			}
		} else {
			$max = 0;
		}
	}
	if ($length_of_marriage == 0) {
		$length_of_marriage = $parent_age - 24;
	}
	
	$numKids = rand(0, $max);
	$kid_details = "";
	$max_age = $length_of_marriage-1;
	for ($k = 0; $k < $numKids; $k++) {
		$kid_age = 0;
		$name = generateForeName();
		$min_age = $max_age - 4;
		if ($min_age < 1) {
			$min_age = 1;
		}
		$max_age = $max_age - 1;
		if ($max_age < $min_age) {
			$max_age = $max_age + 1;
		}
		while ($kid_age <= 0) {
			$kid_age = rand($min_age, $max_age);
			//echo $min_age . ":" . $max_age . "<br/>";
		}
		$kid_details = $kid_details . ucfirst($name) . " (" . $kid_age . "), ";
		$max_age = $kid_age;
		
	}
	
	return [$numKids, substr($kid_details, 0, strlen($kid_details)-2)];

}

function getEducation($title, $age) {
	
	$level = "";
	$course = "";
	$years_of_experience = 0;
	
	if ($title != "Dr" || $title != "Prof") {
	
		$choice = rand(0, 2);
		switch ($choice) {
			case 0:
				$level = "Secondary School";
				$years_of_experience = $age - (17 + rand(0, 1));
				break;
			case 1:
				$level = "College";
				$years_of_experience = $age - (20 + rand(0, 2));
				$course = getCourse();
				break;
			case 2:
				$level = "Undergraduate Degree";
				$years_of_experience = $age - (21 + rand(0, 2));
				$course = getCourse();
				break;
		}
	
	} else {
		$level = "Postgraduate Degree";
		$years_of_experience = $age - 27 + rand(0, 2);
		$course = getLinesFromFile('courses', 1);
	}
	
	return [$level, $course, $years_of_experience];
	
}

function getCourse() {

	$courses = file('lists/courses.txt');
	srand(); # Seed the random number generator
	$index = rand(0, count($courses)-1);
	$course = trim(ucwords(strtolower($courses[$index])));
	
	return $course;
	
}

function getTraits($count) {
	
	$text = "";
	$traits = file('lists/traits.txt');
	$choices = getUniqueArrayChoices(0, count($traits)-1, $count);
	for ($t = 0; $t < $count; $t++) {
		$word = trim($traits[$choices[$t]]);
		$text = $text . "<a href='http://www.dictionary.com/browse/" . lcfirst($word) . "?s=t' target='_blank' title='View definition'>" . $word . "</a>, ";
	}
	
	return substr($text, 0, strlen($text)-2);
	
}

function getValues($count) {
	
	$text = "";
	$values = file('lists/values.txt');
	$choices = getUniqueArrayChoices(0, count($values)-1, $count);
	for ($t = 0; $t < $count; $t++) {
		$word = trim($values[$choices[$t]]);
		$text = $text . "<a href='http://www.dictionary.com/browse/" . lcfirst($word) . "?s=t' target='_blank' title='View definition'>" . $word . "</a>, ";
	}
	
	return substr($text, 0, strlen($text)-2);
	
}

function getLinesFromFile($file, $rows) {
	
	$text = "";
	$values = file("lists/" . $file . ".txt");
	$choices = getUniqueArrayChoices(0, count($values)-1, $rows);
	for ($t = 0; $t < $rows; $t++) {
		$word = ucfirst(trim($values[$choices[$t]]));
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
		$phobia = trim($phobias[rand(0, count($phobias)-2)]);
		$details = explode("- ", $phobia);
		$phobiaName = $details[0];
		$phobiaNames = explode(" or ", $phobiaName);
		$phobiaName = $phobiaNames[0];
		$phobiaDesc = $details[1];
		$text = $text . "<span title='" . $phobiaDesc . "'>" . $phobiaName . "</span>, ";
	}
	
	return substr($text, 0, strlen($text)-2);	
	
}

function getRole($experience) {
	
	$text = "";
	$roles = file('lists/roles.txt');
	for ($r = 0; $r < count($roles); $r++) {
		$details = explode(",", $roles[$r]);
		if ($details[0] == $experience) {
			// Decide if get first one (non-manager) or next one (manager)
			$choice = rand(0, 1);
			if ($choice == 0) {
				$text = $details[1];
			} else {
				$r++;
				$text = explode(",", $roles[$r])[1];
			}
			
		}
		
	}
	
	return $text;
	
}

function getEnvironment() {
	
	// This function will output Location > Device > Operating System > Browser
	$locations = ['Office', 'Onsite', 'Mobile'];
	$desktop_oss = ['Windows','macOS','Linux'];
	$desktop_browsers = ['Chrome','Firefox','Opera','Internet Explorer','Edge'];
	$desktop_devices = ['Desktop','Laptop'];
	$mobile_oss = ['Android','iOS','Windows'];
	$mobile_browsers = ['Chrome','Opera'];
	$mobile_devices = ['Phone','Tablet'];
	$location = $locations[rand(0, count($locations)-1)];
	switch ($location) {
		case "Office":
			$device = "Desktop";
			$device = $desktop_devices[rand(0, count($desktop_devices)-1)];
			$os = $desktop_oss[rand(0, count($desktop_oss)-1)];
			if ($os == "macOS") {
				$browser = "Safari";
			} elseif ($os == "Linux") {
					$browser = "default";
				while ($browser != "Chrome" && $os != "Firefox") {
					$desktop_browsers = ['Chrome','Firefox'];
					$browser = $desktop_browsers[rand(0, count($desktop_browsers)-1)];	
				}
			} else {
				$browser = $desktop_browsers[rand(0, count($desktop_browsers)-1)];	
			}
			break;
		case "Onsite":
			$device = $desktop_devices[rand(0, count($desktop_devices)-1)];
			$os = $desktop_oss[rand(0, count($desktop_oss)-1)];
			if ($os == "macOS") {
				$browser = "Safari";
			} elseif ($os == "Linux") {
					$browser = "default";
				while ($browser != "Chrome" && $os != "Firefox") {
					$desktop_browsers = ['Chrome','Firefox'];
					$browser = $desktop_browsers[rand(0, count($desktop_browsers)-1)];	
				}
			} else {
				$browser = $desktop_browsers[rand(0, count($desktop_browsers)-1)];	
			}
			break;
		case "Mobile":
			$device = $mobile_devices[rand(0, count($mobile_devices)-1)];
			$os = $mobile_oss[rand(0, count($mobile_oss)-1)];
			if ($os == "iOS") {
				$browser = "Safari";
			} elseif ($os == "Windows") {
				$browser = "Internet Explorer";
			} else {
				$browser = $mobile_browsers[rand(0, count($mobile_browsers)-1)];
			}
			break;
	}
	
	return [$location, $device, $os, $browser];
	
}

function getCompany() {
	
	$first = getLinesFromFile('adjectives', 1);
	$second = getLinesFromFile('nouns', 1);
	$suffix = getLinesFromFile('company_suffixes', 1);
	
	return $first . " " . $second . " " . $suffix;
	
}

function getCrime($personaAge) {
	
	$crime_text = "";
	$sentence = 0;
	
	$crime_end_date = strtotime('-4 years');
	$crime_end_date = date("Y", $crime_end_date);
	$crime_range = $personaAge - 16;
	$crime_start_date = $crime_end_date - $crime_range;
	$crimes = getLinesFromFile('crimes', rand(1, 3));
	$crimes = explode(",", $crimes);
	foreach ($crimes as $crime) {
		$crime_text = $crime_text . $crime . " (" . rand($crime_start_date, $crime_end_date) . "), ";
		$sentence = $sentence + rand(1, 10);
	}
	
	$crime_text = substr($crime_text, 0, strlen($crime_text) -2);
	
	return [$crime_text, $sentence];
	
}

function getGeography() {
	
	$locale = ['Urban','Suburban','Rural'];
	$country = getLinesFromFile('countries',1);
	$details = explode(",", $country);
	$country = $details[0];
	
	return $locale[rand(0, count($locale)-1)] . " " . $country;
	
}

function getPet() {
	
	$pet_names = "";
	$num_pets = rand(1, 3);	
	for ($p = 0; $p < $num_pets; $p++) {
		$pet = getLinesFromFile('animals', 1);
		$name = generateForeName();
		$pet_name = $name . " (<a href='https://www.google.co.uk/search?q=" . $pet . "' target='_blank'>" . $pet . "</a>), ";
		$pet_names = $pet_names . $pet_name;
	}
	
	$pet_names = substr($pet_names, 0, strlen($pet_names)-2);
	
	return $pet_names;
	
}

function getDomainExperience($experience) {
	
	// Factor list of experience levels based on user experience to get lowest level to rand from
	$expertise = file('lists/expertise.txt');
	
	$min_exp = ceil(($experience/48)* count($expertise));
	$max_exp = $min_exp + 5;
	if ($max_exp > 13) {
		$max_exp = 13;
	}
	if ($min_exp > 13) {
		$min_exp = 13;
	}
	$expertise_level = rand($min_exp, $max_exp);
	
	return $expertise[$expertise_level];
	
}
	
function getUniqueArrayChoices($min, $max, $count) {
	
	// Get value
	$array = array();
	
	while (count($array) < $count) {
		$value = rand($min, $max);
		if (isValueInArray($value, $array) == false) {
			array_push($array, $value);
		}
	}
	
	return $array;
	
}

function isValueInArray($value, $array) {
	
	$valueIsInArray = false;
	
	for ($v = 0; $v < count($array); $v++) {
		if ($array[$v] == $value) {
			$valueIsInArray = true;
		}
	}
	
	return $valueIsInArray;
	
}
	
function getLanguages($country_code, $work_country) {
	
	$language = array();
	$text = "";
	$work_country = explode(" ", $work_country);
	$work_country = trim($work_country[1]);
	
	// Get Language from Nationality
	$countries = file('lists/countries.txt');
	foreach ($countries as $country) {
		$country_details = explode(",", $country);
		if (trim($country_details[2]) == trim($country_code)) {
			array_push($language, trim($country_details[3]));
		}
		if (trim($country_details[0]) == trim($work_country)) {
			array_push($language, trim($country_details[3]));
		}
	}
	
	$language = array_unique($language); // Removes duplicates
	$language = array_values($language); // Reindexes array
	
	for ($l = 0; $l < count($language); $l++) {
		if ($language[$l] <> "") {
			$text = $text . $language[$l] . ", ";
		}
	}
	
	$text = trimTrailingComma($text);
	return $text;
	
}

function trimTrailingComma($text) {
	
	return substr($text, 0, strlen($text)-2);
	
}
	
function getWorkerType($experience, $role) {
	
	$type = getLinesFromFile('workertype',1);
	$details = explode("|", $type);
	
	return $details;
	
}
	
function getCake() {
	
	$cake = getLinesFromFile('cakes', 1);
	
	return "<a href='https://www.google.co.uk/search?q=" . $cake . "' target='_blank' title='Search for this cake'>" . $cake . "</a>";
	
}
	
?>