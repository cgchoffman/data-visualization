/* CANVAS 2D PIE CHART
 * Args:
 * [1] chartId: 'yourCanvasElementId'
 * [2] colours: ['#f00', '#0f0', '#00f'] 
 *     permissible colour specs:
 *     - red
 *     - #ff0000
 *     - #f00
 *     - rgb(255,0,0)
 *     - rgba(255,0,0,0.5) (alpha range: 0.0-1.0)
 * [3] angles: [60, 90, 210] (360 deg overall) 
 * Note: colours and angles arrays must have identical length.
 */

function piechart(chartId, colours, angles, labels) {

	var canvas  = document.getElementById(chartId);
	var context = canvas.getContext("2d");
	var x = Math.floor(canvas.width  / 2);
	var y = Math.floor(canvas.height / 2);
	var total = angles[0] + angles[1];
	var startAngle = 0.0;

	for (var i = 0; i < colours.length; i++) {
		drawSegment(colours[i], angles[i], labels[i]);
	}

	function drawSegment(colour, angle, label) {
		var endAngle = startAngle + parseFloat((angle/total)*360) * Math.PI / 180;
		var r = x > y ? y : x;
		context.beginPath();
		context.moveTo(x, y);
		context.arc(x, y, r*.7, startAngle, endAngle, false);
		context.fillStyle = colour;
		context.fill();
		context.font = r*.1 + 'pt sans-serif';
		context.fillStyle = '#555';
		context.textAlign = 'center';
		context.textBaseline = 'middle';
		var middleAngle = startAngle + (endAngle-startAngle)/2;
		context.fillText(
			label, 
			x + r*.9 * Math.cos(middleAngle), 
			y + r*.9 * Math.sin(middleAngle)
		);
		context.closePath();
		startAngle = endAngle;
	}

}
