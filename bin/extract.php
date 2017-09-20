<?php

	$text = "";

	for ($c = 65; $c <= 90; $c++) {
		$url = "https://www.careerplanner.com/Job-Descriptions-DOT/" . chr($c) . ".cfm";
		$file_contents = file_get_contents($url);
	
		$text = $text . "<br/>" . substr($file_contents, strpos($file_contents, "Job Descriptions that Start with the Letter"), strpos($file_contents, "Wondering what career you should pursue?"));	
	
	}
	
	file_put_contents('jobs.txt', $text);
	
	echo "Done!";

?>