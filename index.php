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
			displayPersonaProfile($details);
		?>
    </div>
    
    <div id="footer">
        <div id="section" class="footer">Created by <a href='https://twitter.com/rocketbootkid'>@rocketbootkid</a>. The people depicted here are randomly generated and completely fictitious. Any similarity to any person, alive or dead, is purely coindcidental.<p>
		Some Persona information (Image, Name, DoB, Nationality) consumed from <a href='https://randomuser.me/'>randomuser.me</a>, Sayings from <a href='http://random-randareno.blogspot.co.uk/2011/04/100-random-things-to-say.html' target='_blank'>http://random-randareno.blogspot.co.uk/2011/04/100-random-things-to-say.html</a> and <a href='http://www.fun-stuff-to-do.com/Funny-things-to-say.html' target='_blank'>http://www.fun-stuff-to-do.com/Funny-things-to-say.html</a>, Likes & Dislikes from <a href='https://www.homeofpoi.com/en/community/forums/topics/952714/1/Random-list-of-likes-and-dislikes' target='_blank'>https://www.homeofpoi.com/en/community/forums/topics/952714/1/Random-list-of-likes-and-dislikes</a></div>
    </div>
	
</div>

<canvas id="myCanvas" width="2000" height="1000"></canvas>
<script src="js/background.js"></script>

</body>
</html>