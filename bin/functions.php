<?php

function displayPersona() {

	echo generateName();
	//echo generateAge();
	echo generateDOB();

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

function generateDOB() {
	
	return date("M-d-Y",strtotime("-70 year"));
	
}

function generateAge($dob) {
	
	srand(); # Seed the random number generator
	
	return rand(22, 70);
	
}






?>