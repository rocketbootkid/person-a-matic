<!DOCTYPE php>

<?php
	include ('bin/functions.php');
?>
 
<html>
    <head>
        <title>Personomicon | Random Software Testing Personas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
			a { text-decoration:none; }
			div#content {
				position: absolute;
			}
		</style>
    </head>
    <body>
		<div id="title"></div>
		<div id="content">
			<?php
				displayPersona();
			?>
		</div>
		<canvas id="myCanvas" width="2000" height="1000"></canvas>
		<script src="js/background.js"></script>
    </body>
</html>
