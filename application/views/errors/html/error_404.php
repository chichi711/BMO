<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>
<!-- 
		<section id="slider" class="slider-element min-vh-60 min-vh-md-100 dark error404-wrap include-header" style="background: url(images/landing/static.jpg) center;">
			<div class="slider-inner">

				<div class="vertical-middle">
					<div class="container text-center py-5 py-md-0">

						<div class="error404">404</div>

						<div class="heading-block border-bottom-0">
							<h4>Ooopps.! The Page you were looking for, couldn't be found.</h4>
							<span>Try the search below to find matching pages:</span>
						</div>

						<form action="#" method="get" class="mx-auto mb-0">
							<div class="input-group input-group-lg">
								<input type="text" class="form-control" placeholder="Search for Pages...">
								<div class="input-group-append">
									<button class="btn btn-danger" type="button"><i class="icon-line-search"></i></button>
								</div>
							</div>
						</form>

					</div>
				</div>

			</div>
		</section>


	</div> -->
