<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.php');
	exit;
}
    
include("db-config.php");

$conn = new mysqli($servername, $username, $password, $dbname);

if(isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    mysqli_close($conn);
    echo("No id provided");
    die;
}

// $myquery = "
// SELECT * FROM collections WHERE `id` = '.$id.""'
// ";
$myqueryCheck = "
SELECT * FROM collections WHERE `id` = '".$id."'
";
$queryCheck = mysqli_query($conn,$myqueryCheck);

if ( ! $queryCheck ) {
    echo mysql_error();
    die;
}

$myquery = "
DELETE FROM collections WHERE `id` = '".$id."'
";
$query = mysqli_query($conn,$myquery);

if ( ! $query ) {
    echo mysql_error();
    die;
}

echo ("You have deleted the collection");

mysqli_close($conn);
?>