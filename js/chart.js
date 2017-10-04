var canvas = document.getElementById('chartCanvas');
var context = canvas.getContext('2d');

var canvasRadius = context.canvas.height/2;
var canvasMidX = context.canvas.width/2;
var canvasMidY = context.canvas.height/2;
var chartRadius = Math.ceil(canvasRadius*0.85);
var attributes = ["Confidence","Proactivity","Resilience","Adaptability","Positivity","Self-motivation","Leadership","Dependability","Problem-Solving","Organisation","Trustworthiness","Communication","Creativity","Diplomacy"];
var numAttributes = attributes.length;
console.log(attributes);

drawBullseye();
drawGraph();

// ******************************************************************************
//                              FUNCTIONS
// ******************************************************************************

function drawBullseye() {
	
	// Draw circles
	
	context.strokeStyle = "#555";
	
	context.beginPath();
	context.arc(canvasMidX, canvasMidY, chartRadius*0.2, 0, Math.PI*2);
	context.stroke();
	
	context.beginPath();
	context.arc(canvasMidX, canvasMidY, chartRadius*0.4, 0, Math.PI*2);
	context.stroke();

	context.beginPath();
	context.arc(canvasMidX, canvasMidY, chartRadius*0.6, 0, Math.PI*2);
	context.stroke();
	
	context.beginPath();
	context.arc(canvasMidX, canvasMidY, chartRadius*0.8, 0, Math.PI*2);
	context.stroke();
	
	context.strokeStyle = "#555";
	
	context.beginPath();
	context.arc(canvasMidX, canvasMidY, chartRadius, 0, Math.PI*2);
	context.stroke();	

	// Draw radials
	
	for (i=0;i<numAttributes;i++) {
		radius = chartRadius;
		angle = Math.PI*(2/numAttributes)*i;
		
		coords = getXY(radius, angle);
		x = coords.x + canvasMidX;
		y = coords.y + canvasMidY;
		
		//console.log("Coords: " + coords.x + ", " + coords.y);
		
		context.beginPath();
		context.strokeStyle = "#555";
		context.moveTo(canvasMidX, canvasMidY);
		context.lineTo(x, y);
		context.zIndex = 50;
		context.lineWidth = 1;
		context.stroke();
		
		drawLabel(radius, angle, i);
		
	}
	
}

function drawGraph() {
	
	context.beginPath();
	context.moveTo(canvasMidX, canvasMidY);

	radius = Math.ceil(Math.random()*8) + 2;
	console.log("Radius: " + radius);
	radius = Math.ceil(radius * (chartRadius/10));
	console.log("Radius Multi: " + radius);
	
	angle = Math.PI*(2);
	
	// Start Position
	
	coords = getXY(radius, angle);
	x = coords.x + canvasMidX;
	y = coords.y + canvasMidY;
	
	context.beginPath();
	context.moveTo(x, y);
	context.stroke();	
	
	previous_x = x;
	previous_y = y;
	
	start_x = x;
	start_y = y;
	
	// Draw points
	
	for (i=1;i<numAttributes;i++) {
		radius = Math.ceil(Math.random()*8) + 2;
		console.log("Radius: " + radius);
		radius = Math.ceil(radius * (chartRadius/10));
		console.log("Radius Multi: " + radius);
		angle = Math.PI*(2/numAttributes)*i;
				
		coords = getXY(radius, angle);
		x = coords.x + canvasMidX;
		y = coords.y + canvasMidY;
		
		context.beginPath();
		context.strokeStyle = "red";
		context.moveTo(previous_x, previous_y);
		context.lineTo(x, y);
		context.zIndex = 50;
		context.lineWidth = 2;
		context.stroke();
	
		previous_x = x;
		previous_y = y;
		
	}
	
	// Join up to start
	
	context.beginPath();
	context.strokeStyle = "red";
	context.moveTo(previous_x, previous_y);
	context.lineTo(start_x, start_y);
	context.zIndex = 50;
	context.lineWidth = 2;
	context.stroke();

}

function getXY(radius, angle) {
	
	x = Math.ceil(Math.cos(angle) * radius);
	y = Math.ceil(Math.sin(angle) * radius);
	
	return {x:x, y:y};
	
}

function drawLabel(radius, angle, labelText) {
	
	radius = radius + 10;	
	coords = getXY(radius, angle);
	x = coords.x + canvasMidX - 2;
	y = coords.y + canvasMidY + 4;
	
	console.log("X: " + x);
	
	context.beginPath();
	context.font = "12px Georgia black";
	context.strokeStyle = "black";
	if (x < canvasMidX) {
		context.textAlign = "right";
	} else {
		context.textAlign = "left";
	}
	context.fillText(attributes[i], x, y)
	context.stroke();
	
}