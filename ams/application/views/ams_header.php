<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AMS Header</title>
	<base href="http://10.0.0.20/ams/" target="_self" />
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/jquery-ui.css">
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/page-layout.css"/>
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/page-header.css"/>
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/page-footer.css"/>
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/colorbox.css"/>
	<link media="screen" type="text/css" rel="stylesheet" href="./assets/ams/css/validationEngine.jquery.css"/>
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script src="./assets/ams/js/jquery.colorbox.js"></script>
	<script src="./assets/ams/js/jquery.validationEngine-en.js"></script>
	<script src="./assets/ams/js/jquery.validationEngine.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//javascript hack to fix the content height mismatch between firefox and chrome
			if ($.browser.mozilla) {
    				$('#content_wrapper').css('height','680px');
			}
			
			//background remove for the menu section		
			$("#nav li").hover(
				function(){
					$("#nav .current").removeClass("current");
				},
				function(){
					$(this).addClass("current");
				}
			);
			
		});
	</script>	
</head>
<body>
	<!--
		naming convention:
		id 			section		section_first
		class			section		section-first
		javascript var		variable	varName
		javascript function	function()	functionName()
		php var			$var		$varName
		php function		function()	functionName()
		css filename		style.css	header-style.css
		javascript filename	javasript.js	javascriptFile.js
		php filename		first.php	first_file.php
	-->
	<div id="page_wrapper">	
		<div id="page_header">
			<div id="credential" class="center-layout">
				<a href='main/logout'>Logout</a>
			</div>
			<div id="logo_heading" class="center-layout">
				<div id="logo">
				<img src="./assets/ams/images/ams_logo.png"/>
				</div>
				<div id="logo_title">
				<img src="./assets/ams/images/ams_title.png"/>
				</div>
			</div>	
		</div>
		<div id="nav_menu">
			<div id="crumb_nav" class="center-layout">
				<ul id="nav">
					<li class="current"><a href="main">Home</a></li>
					<li><a href="account">Account</a>
						<ul>
							<li><a href="account/password">Password Reset</a></li>
							<li><a href="account/singleAccount">New User</a></li>
						</ul>	
					</li>
					<li><a href="multiple">Upload</a></li>
					<li><a href="analysis">Analysis</a>
						<ul>
							<li><a href="analysis/crossSystem">Cross System</a></li>
							<li><a href="analysis/conformity">Conformity</a></li>
							<li><a href="analysis/activity">Activity</a></li>
						</ul>
					</li>
					<li><a href="#">Documentation</a>
						<ul>
							<li><a>Policies</a></li>
							<li><a>System</a></li>
						</ul>
					</li>
				</ul>	
			</div>
		</div>		



