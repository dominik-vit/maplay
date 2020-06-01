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
// SELECT * FROM collections WHERE `id` = '".$id."'
// ";
$myquery = "
SELECT  `lat`, `lon`, `datum`, `name` FROM  `points`
WHERE `lat` <> 0
AND `collectionID` = '".$id."'
ORDER BY DATE(datum) ASC
";
$query = mysqli_query($conn,$myquery);

if ( ! $query ) {
    echo mysql_error();
    die;
}

$data = array();


while($row = mysqli_fetch_assoc($query)){
    $data[] = $row;
}

echo json_encode($data);

mysqli_close($conn);
?>