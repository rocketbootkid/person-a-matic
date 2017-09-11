var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');

// Make canvas size of window
context.canvas.width = window.innerWidth - 20;
context.canvas.height = window.innerHeight - 20;

var canvasDimensions = {
		width: window.innerWidth,
		mid_x: window.innerWidth/2,
		mid_y: window.innerHeight/2,
		height: window.innerHeight
	};

	
var segmentLength = 18; // How long each segment of a horison is
var segmentCount = Math.ceil(canvasDimensions.width/segmentLength); // Determine how many segments fit on screen
var horizonCount = 12;
var horizonStartY = canvasDimensions.mid_y;
var staticHorizonStartY = canvasDimensions.mid_y;
var horizonStartX = 0;
var horizonChangeMax = 15; // Amount by which points on horizon can vary +/- vertically
var horizonDeltaY = 10; // Amount by which different horizons differ vertically
var horizonSmootheningFactor = 4; // Amount by which nearer horizons become smoother
var horizonNeareningFactor = 1; // Amount by which nearer horizons get lower

//drawSky();
drawHills();
drawFooterText();
drawTitleText();
drawContextFrame();

// ******************************************************************************
//                              FUNCTIONS
// ******************************************************************************

function drawSky() {
	
	context.beginPath();
	var sky = context.createLinearGradient(0, 0, 0, canvasDimensions.height/2);
	sky.addColorStop(0, "#3366ff");
	sky.addColorStop(0.7, "#ffd1b3");
	sky.addColorStop(1, "orange");
	context.fillStyle = sky;
	context.fillRect(0, 0, canvasDimensions.width, canvasDimensions.height*2/3);
	
}

function drawHills() {
	
	for (h = 0; h < horizonCount; h++) {
		
		drawHorizon();
		
		// Set / reset parameters for next horizon
		horizonStartY = staticHorizonStartY + (h * horizonDeltaY) + (Math.ceil(Math.random()*2*horizonDeltaY)) - horizonDeltaY; // Make next horizon lower down
		horizonStartX = 0; // Start back at left hand end
		segmentLength = segmentLength + horizonSmootheningFactor; // Make closer horizons smoother
		horizonDeltaY = horizonDeltaY + horizonNeareningFactor;

	}	
	
}

function drawHorizon() {
    
	context.beginPath();
	context.moveTo(horizonStartX, horizonStartY);
	for (s = 0; s < segmentCount; s++) {
		
		horizonStartX = horizonStartX + segmentLength;
		horizonStartY = horizonStartY + (Math.ceil(Math.random()*2*horizonChangeMax)) - horizonChangeMax;
		
		context.lineTo(horizonStartX, horizonStartY); // Draw segment
		
	}
	
	// Draw bottom corners
	context.lineTo(canvasDimensions.width, canvasDimensions.height); // Bottom right
	context.lineTo(0, canvasDimensions.height); // Bottom left
	
	context.closePath();
	
	context.fillStyle = generateSegmentColor(h);
		
	context.fill();
     
}

function generateSegmentColor(horizonCount) {
    
	// Generates a slowly darkening gray color hex string

	var value = 14 - horizonCount;
    color = "#" + value.toString(16) + value.toString(16) + value.toString(16);
    return color;
    
}

function drawFooterText() {
	
	context.beginPath();
	context.fillStyle = "white";
	context.textAlign = "center";
	context.font = "16px Georgia";
	context.fillText("Created by @rocketbootkid", canvasDimensions.mid_x, canvasDimensions.height - 40);
	
}

function drawTitleText() {
	
	context.beginPath();
	context.fillStyle = "white";
	context.font = "50px Georgia";
	context.fillText("Personomicon", canvasDimensions.mid_x, canvasDimensions.height - 100);
	
}

function drawContextFrame() {

	context.beginPath();
	context.fillStyle = "#ddd";
	context.fillRect(canvasDimensions.mid_x - 500, 30, 1000, canvasDimensions.height - 200);
	
	context.beginPath();
	context.fillStyle = "white";
	context.fillRect(canvasDimensions.mid_x - 490, 40, 980, canvasDimensions.height - 220);
	
	contentDiv = document.getElementById("content").style;
	contentDiv.left = canvasDimensions.mid_x - 472;
	contentDiv.top = 57;
	contentDiv.width = 960;
	contentDiv.height = canvasDimensions.height - 240;
	
}