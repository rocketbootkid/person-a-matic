<?php
	include ('bin/functions.php');
?>

<html>
<head>
	<title>Personomicon | Random Software Testing Personas</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="container">
    
    <div id="content">
		<?php
			$details = displayPersonaDemographics();
			echo "</div><div id='sidebar'>";
			displayPersonaProfile($details[0], $details[1]);
		?>
    </div>
    
    <div id="footer">
        <div id="section" class="footer">Created by <a href='https://twitter.com/rocketbootkid'>@rocketbootkid</a>. The people depicted here are randomly generated and completely fictitious. Any similarity to any person, alive or dead, is purely coindcidental.</div>
    </div>
	
</div>

<canvas id="myCanvas" width="2000" height="1000"></canvas>
<script src="js/background.js"></script>

</body>
</html>