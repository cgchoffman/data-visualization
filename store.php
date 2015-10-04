<!DOCTYPE html> 
<html>
   <head>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" type="text/css">
	  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	  <link rel="stylesheet" href="css/custom.css" type="text/css"><!--my custom css rules.  doesn't exist until i make it.-->
	  <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	  <script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
	  <script type="text/javascript" src="js/d3.js"></script>
	  <script type="text/javascript" src="js/d3.geom.js"></script>
	  <script type="text/javascript" src="js/d3.layout.js"></script>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <title>Sample Client-Server Web App</title>
   </head>
   <body>
	  <div data-role="page">
		 <div data-role="header">
			<h2>Processing Response...</h2>
		 </div><!-- /header -->
		 <!--MAIN CONTENT HERE-->
   
		 <div data-role="content">
			<div class="container-fluid">
			   <div class="row row-centered">
				  <div class="col-sm-6 col-centered">
				  <!--<div id="proc-resp" class="col-sm-6 col-centered">-->
					 <?php
						$file_handle = fopen('data/data.json', 'a');  // a - append, w - overwrite
						if($file_handle) {                       // if file is there
						   //  Check if post data is empty.  Don't use it if it's empty.
						   fwrite(                               // write to file
							  $file_handle,                      // specified by $file_handle
							  json_encode($_POST).PHP_EOL);      // json-encoded POST data (terminate with end of line)
						   fclose($file_handle);                 // close file stream
						   echo 'Data submitted successfully.';  // inform of success
						// header('Location:done.html');         // or show another html
						}
						else {
						   echo 'Error opening data file.';      // inform of failure
						}
					 ?>
				  </div>
			   </div>
			</div>
		 </div><!-- /content -->
   
		 <div data-role="footer">
			<div class="row row-centered">
			   <div class="col-sm-6 col-centered">
				  <a href="index.html" data-role="button" data-icon="arrow-l">Submit Again</a>
				  <a href="retrieve.php" data-role="button" data-icon="arrow-r">Visualize Data Set</a>
			   </div>
			</div>
		 </div><!-- /header -->
	  </div><!-- /page -->
   </body>
</html>
