<!DOCTYPE php>

<?php
	include ('bin/functions.php');
?>
 
<html>
    <head>
        <title>Personomicon | About</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
		<div id="title"></div>
		<div id="content">
			<div class='name'>About</div>
			<div class='linetitle'>Sayings</div>
			<div class='linecontent'>
			http://random-randareno.blogspot.co.uk/2011/04/100-random-things-to-say.html<br/>
			http://www.fun-stuff-to-do.com/Funny-things-to-say.html
			</div>
			<div class='linetitle'>Persona Information</div>
			<div class='linecontent'>
			Some Persona information (Image, Name, Nationality) consumed from <a href='https://randomuser.me/'>randomuser.me</a>
			</div>
			<div class='linetitle'>Likes & Dislikes</div>
			<div class='linecontent'>
			https://www.homeofpoi.com/en/community/forums/topics/952714/1/Random-list-of-likes-and-dislikes
			</div>
		</div>
		<canvas id="myCanvas" width="2000" height="1000"></canvas>
		<script src="js/background.js"></script>
    </body>
</html>
