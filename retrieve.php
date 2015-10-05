<!DOCTYPE html> 
<html> 
	<head> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
		<link rel="stylesheet" href="css/custom.css" type="text/css"><!--my custom css rules.  doesn't exist until i make it.-->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
		<script type="text/javascript" src="js/d3.js"></script>
		<script type="text/javascript" src="js/d3.geom.js"></script>
		<script type="text/javascript" src="js/d3.layout.js"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Sample Client-Server Web App</title>
	</head> 
	<body> 
		<div data-role="page">
		
			<div data-role="header">
				<h2>Gender stastistics:</h2>
			</div><!-- /header -->
		
			<!--MAIN CONTENT HERE-->
			<div data-role="content">
				<div class="container-fluid">
					<?php
					$file = fopen('data/data.json', "r")           // open file
							or exit('Data not found.
							<a href="index.html" data-role="button" data-icon="back">Submit Again</a>');// or give err msg and exit
					$linecount = 0;
					while(!feof($file)){
					  $line = fgets($file, 4096);
					  $linecount = $linecount + substr_count($line, PHP_EOL);
					}
					fclose($file);			// close file handle

					
					$file = fopen('data/data.json', "r")           // open file
							or exit('Data not found.
							<a href="index.html" data-role="button" data-icon="back">Submit Again</a>');// or give err msg and exit
					$skimmer = 1;
					if($linecount >= 500 && $linecount < 1000)
					{
						$skimmer = 2;
					} else if ($linecount >= 1000 && $linecount < 2000)
					{
						$skimmer = 3;	
					} else if ($linecount >= 2000)
					{
						$skimmer= 4;
					}
						
					while(!feof($file))                       // while eof not reached
					{
						$line = fgets($file);                 // get one line
						$data = json_decode($line, TRUE);     // json-decode it, $assoc
						if (is_array($data)) {                // if decoded data is an array
							foreach ($data as $key => $value) // iterate through assoc array
							{
							   if (strcmp($value, "female"))
							   {
									$FEMALE++;
								}
								else
								{
									$MALE++;
								}
							}
						}
					}
				
					fclose($file);			// close file handle
					$total = $FEMALE + $MALE + 1;
					$total = ($total) > 2 ? $total : 2;
					$girl = "red";
					$boy = "black";
					
					?>
					<h1>Data Collision Detection</h1>
					<div id="body" class="container">
						<svg width="50" height="50">
							<circle cx="25" cy="25" r="25" fill="<?php echo $girl ?>" />
						</svg>
						<strong>Ladies</strong>
						<svg width="50" height="50">
							<circle cx="25" cy="25" r="25" fill="<?php echo $boy ?>" />
						</svg>
						<strong>Gentlemen</strong>
						<div id="footer" class="row">
						
							<div id="hint" class="col-md-12"></div>
						</div>
					</div>
				</div>
			</div><!-- /content -->
		
		
			<div data-role="footer">
				<div class="row row-centered">
					<div class="col-sm-6 col-centered">
						<a href="index.html" data-role="button" data-icon="back">Submit Again</a>
					</div>
				</div>
			</div><!-- /header -->
			
		<script type="text/javascript">

var w = $(window).width(),
    h = 400;
var nodes = d3.range(<?php echo $total/$skimmer ?>).map(function() { return {radius: Math.random() * 12 + 4}; }),
    color = d3.scale.category10();

var force = d3.layout.force()
    .gravity(0.05)
    .charge(function(d, i) { return i ? 0 : -2000; })
    .nodes(nodes)
    .size([w, h]);

var root = nodes[0];
root.radius = 0;
root.fixed = true;

force.start();
var svg = d3.select("#hint").append("svg:svg")
    .attr("width", w)
    .attr("height", h);

function colourByPercentage(){
    var girls = <?php echo $FEMALE ?>;
    var boys = <?php echo $MALE ?>;
    var num = Math.random();
    return (girls/(girls+boys)) > num ? "<?php echo $boy ?>" : "<?php echo $girl ?>";
}
svg.selectAll("circle")
    .data(nodes.slice(1))
    .enter().append("svg:circle")
    .attr("r", function(d) { return d.radius - 2; })
    .style("fill", function(d, i) { return colourByPercentage(); });

force.on("tick", function(e) {
  var q = d3.geom.quadtree(nodes),
      i = 0,
      n = nodes.length;

  while (++i < n) {
    q.visit(collide(nodes[i]));
  }

  svg.selectAll("circle")
      .attr("cx", function(d) { return d.x; })
      .attr("cy", function(d) { return d.y; });
});

svg.on("mousemove", function() {
  var p1 = d3.svg.mouse(this);
  root.px = p1[0];
  root.py = p1[1];
  force.resume();
});

function collide(node) {
  var r = node.radius + 100,
      nx1 = node.x - r,
      nx2 = node.x + r,
      ny1 = node.y - r,
      ny2 = node.y + r;
  return function(quad, x1, y1, x2, y2) {
    if (quad.point && (quad.point !== node)) {
      var x = node.x - quad.point.x,
          y = node.y - quad.point.y,
          l = Math.sqrt(x * x + y * y),
          r = node.radius + quad.point.radius;
      if (l < r) {
        l = (l - r) / l * .5;
        node.x -= x *= l;
        node.y -= y *= l;
        quad.point.x += x;
        quad.point.y += y;
      }
    }
    return x1 > nx2
        || x2 < nx1
        || y1 > ny2
        || y2 < ny1;
  };
}

    </script>
		
		</div><!-- /page -->
	</body>
</html>
