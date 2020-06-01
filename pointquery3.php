<?php
session_start();

    
include("db-config.php");

$conn = new mysqli($servername, $username, $password, $dbname);


$myquery = "
SELECT  `lat`, `lon`, `datum`, `name` FROM  `points`
WHERE `lat` <> 0
AND `userID` = '".$_SESSION['id']."'
AND `collectionID` = '".$_SESSION['collectionID']."'
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