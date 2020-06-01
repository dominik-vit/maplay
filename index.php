<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
// if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    
// } else {
// 	header('Location: index.html');
// 	exit;
// }
?>
<!DOCTYPE HTML>

<html>
	<head>
		<title>maplay | home</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<nav class="left">
					<a href="#menu"><span>Menu</span></a>
				</nav>
				<a href="index.php" class="logo">maplay</a>
				<nav class="right">
<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	echo '<a href="phplogin/logout.php" class="button alt">Log out</a>';
} else {
	echo '<a href="acc-index.php" class="button alt">Log in</a><a href="acc-register.html" class="button alt">Sign up</a>';
}

?>
				</nav>
			</header>

		<!-- Menu -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="mp-points.php">Add locations</a></li>
					<li><a href="mp-visual.php">Visualize</a></li>
					<li><a href="mp-read.php">Edit</a></li>
					<li><a href="acc-profile.php">Profile</a></li>
				</ul>
				<ul class="actions vertical">
					<li><a href="#" class="button fit">Login</a></li>
				</ul>
			</nav>

		<!-- Banner -->
			<section id="banner">
				<div class="content">
					<h1>Welcome to MAPLAY!</h1>
					<p>Make your moves move again.</p>
					<ul class="actions">
						<li><a href="#one" class="button scrolly">why Maplay?</a></li>
						<li><a href="acc-register.html" class="button">join now!</a></li>
					</ul>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper">
				<div class="inner flex flex-3">
					<div class="flex-item left">
						<div>
							<h3>How to start</h3>
							<p>Sign up, log in.<br /> Easy, simple.</p>
						</div>
						<div>
							<h3>Add your own points</h3>
							<p>Just by clicking them into map <br /> or import geoJSON file with point features</p>
						</div>
					</div>
					<div class="flex-item image fit round">
						<img src="images/pic06.jpg" alt="" />
					</div>
					<div class="flex-item right">
						<div>
							<h3>Play your map</h3>
							<p> choose your collection or display all your stuff <br /> and visualize it with tour mode or drawing a line</p>
						</div>
						<div>
							<h3>Edit, compare, share</h3>
							<p> Edit your places and then <br /> join others points to your own map and enjoy together! </p>
						</div>
					</div>
				</div>
			</section>

		<!-- Two -->
			<section id="two" class="wrapper style1 special">
				<div class="inner">
					<h2 href="odkaz">Bachelor thesis main page</h2>
					<figure>
					    <blockquote>
					        "Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra<br /> magna etiam lorem ultricies in diam. Sed arcu cras consequat."
					    </blockquote>
					    <footer>
					        <cite class="author">Dominik Vit</cite>
					        <cite class="company"></cite>
					    </footer>
					</figure>
				</div>
			</section>

		<!-- Three -->


		<!-- Footer -->
			<footer id="footer">
				<div class="inner">
					<h2>Problem? Let me know.</h2>
					<ul class="actions">
						<li><span class="icon fa-envelope"></span> <a href="mailto:dominik.vit01@upol.cz?subject=Maplay_issue">dominik.vit01@upol.cz</a></li>
						<li><span class="icon fa-map-marker"></span> Olomouc, Czechia</li>
					</ul>
				</div>
				<div class="copyright">
					&copy; 2020 | Dominik Vít | <a href="http://www.geoinformatics.upol.cz/">Dept. of Geinformatics of Palacky university.</a> <br>
					This app was made as a bachelor thesis project.
					 Desing made with <a href="https://templated.co">TEMPLATED</a>. Images <a href="https://unsplash.com">Unsplash</a>.
				</div>
			</footer>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>