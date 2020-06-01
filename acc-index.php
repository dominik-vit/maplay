<?php

session_start();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="assets/css/main.css" rel="stylesheet" type="text/css">
	</head>
	<body>

		    <body class="subpage">

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
                </ul>
                <ul class="actions vertical">
                    <li><a href="acc-index.php" class="button fit">Login</a></li>
                    <li><a href="acc-register.html" class="button fit">Sign up</a></li>
                </ul>
            </nav>
		<div class="inner">
            <div class="login">
                <h1>Login</h1>
                <form action="phplogin/acc-authenticate.php" method="post">
                    <input type="text" name="username" placeholder="Username" id="username" style="margin-bottom:30px;" required>
                    <input type="password" name="password" placeholder="Password" id="password" style="margin-bottom:30px;" required>
                    <input type="submit" value="Login">
                </form>
            </div>
        </div>
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
                     Design made with <a href="https://templated.co">TEMPLATED</a>.
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
	</body>
</html>