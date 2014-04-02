<!DOCTYPE HTML>

<html>
	<head>
		<?php
			if (isset($title)) {
				echo "<title>$title</title>";
			}
		?>

		<link rel="shortcut icon" href="img/fav_icon.png" type="image/x-icon">
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/custom.css">
		<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
		<!-- włączenie jQuery ma być tutaj inaczej nie dziala pod operą --> 
		<script language="javascript" type="text/javascript" src="js/Lib/jquery-1.11.0.min.js"></script>
		<?php
			if (isset($csses)) {
				foreach ($csses as $value) {
					echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$value\">";
				}
				echo "\n";
			}
			$dataPrinted = false;
			if (isset($scripts)) {
				foreach ($scripts as $value) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$value\"></script>";
					if ($dataPrinted == false) {
						$dataPrinted = true;
					}
				}
			}
			if (isset($scriptsDefer)) {
				foreach ($scriptsDefer as $value) {
					echo "<script language=\"javascript\" type=\"text/javascript\" src=\"$value\" defer></script>";
					if ($dataPrinted == false) {
						$dataPrinted = true;
					}
				}
			}
			if ($dataPrinted == true) {
				echo "\n";
			}
		?>
	</head>

	<body style="background-image: url('img/books.jpg'); padding-top: 70px; height: 100%;">
		<?php include_once("Navbar.php"); ?>
 		<div id="wrapper" class="container col-md-12 col-sm-12" style="padding-left: 0px; padding-right: 0px;">
<!-- 			<div class="container col-md-12" style="padding: 0px; padding-top:0px;"> -->
				<div id="content_wrapper">
				<div class="panel col-md-12 col-sm-12" style="padding: 20px; background: rgba(255, 255, 255, 0.9);">