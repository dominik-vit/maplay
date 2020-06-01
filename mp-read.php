<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
?>





<!DOCTYPE HTML>

<html>
    <head>
        <title>Your Points</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.2.1/css/ol.css" type="text/css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    
        <script src="ol.js"></script>
    <style>
      .map {
        width: 100%;
        height:400px;
      }
    </style>
    <script src="ol.js">
        
    </script>
    
  </head>
    <body class="subpage">

        <!-- Header -->
            <header id="header">
                <nav class="left">
                    <a href="#menu"><span>Menu</span></a>
                </nav>
                <a href="index.php" class="logo">maplay</a>
                <nav class="right">
                    <a href="phplogin/logout.php" class="button alt">Log out</a>
                    <a href="acc-index.php" class="button alt">Log in</a>
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





<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our points table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM points WHERE userID = '.$_SESSION['id'].' ORDER BY id  LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of points, this is so we can determine whether there should be a next and previous button
$num_points = $pdo->query('SELECT COUNT(*) FROM points')->fetchColumn();
?>


<?=template_header('Read')?>

<div class="content read">
	<h2>Edit Points</h2>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>lat</td>
                <td>lon</td>
                <td>name</td>
                <td>date</td>
                <td>visibility</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($points as $point): ?>
            <tr>
                <td><?=$point['id']?></td>
                <td><?=$point['lat']?></td>
                <td><?=$point['lon']?></td>
                <td><?=$point['name']?></td>
                <td><?=$point['datum']?></td>
                <td><?=$point['visibility']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$point['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$point['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="mp-read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_points): ?>
		<a href="mp-read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
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

            <style>
                .pagination {
                  display: inline-block;
                }

                .pagination a {
                  color: #727a82;
                  float: right;
                  padding: 8px 16px;
                  text-decoration: none;
                }

                .pagination a.active {
                  background-color: #4CAF50;
                  color: white;
                }

                .pagination a:hover:not(.active) {background-color: #ddd;}
            </style>

        <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/jquery.scrolly.min.js"></script>
            <script src="assets/js/skel.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>

    </body>
</html>