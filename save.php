<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();

include("db-config.php");



// $pripoj= mysqli_connect($SQL_Server,$SQL_Uzivatel,$SQL_Password,$Databaze);
$pripoj = new mysqli($servername, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



// data jsou poslana v jsonu tak jemusime prvni decokovat
$data = json_decode($_POST["data"]);

$data_arr = (array) $data;

$last_id = NULL;
$userID = $_SESSION["id"];

$collection_arr = (array) $data_arr["collection"];

if (count($collection_arr) != 0) {

  foreach ($data_arr["collection"] as &$line) {
    // PHP nám ten jeden zápis řádku parsuje jako nějaký objekt a ne jako pole
    // a tak se musí ten zápis line prvni convertovat na pole a to díky (array) před $line
    $line_arr = (array) $line;
    
    // nyní se může vybrat naše potřebné informace o zadaném bodu, 
    $name = $line_arr["name"];
    $public = $line_arr["public"];
    
    $sql = "INSERT INTO collections (collNAME, public, userID) VALUES ('$name','$public','$userID')";
    
    // pomoci try catch radeji kontrola jestli nedojde k nejake chybe
    // pokud by se z jakehokoliv duvodu vlozeni do db nepovedlo tak se smyčka ukončí a pošle chybové hlášení
    try {
      $vysledek = mysqli_query($pripoj, $sql);

    } catch (mysqli_sql_exception $e) {
      $response_array['status'] = false;
      $response_array['message'] = "Something went wrong";
      echo json_encode($response_array);
      break;
    }


  }

  $last_id = mysqli_insert_id($pripoj);

}



// je to pole a tak se udela foreach smyčka kde se kazdy radek řesi jednotlivě
foreach ($data_arr["points"] as &$line) {
  // PHP  ten jeden zápis řádku parsuje jako nějaký objekt a ne jako pole
  // a tak je nutne ten zápis line prvni convertovat na pole a to díky (array) před $line
  $line_arr = (array) $line;

  // nyní nasleduje vyber potřebnych informaci o zadaném bodu, 

  $latitude = $line_arr["lat"];
  $longitude = $line_arr["lon"];
  $jmeno = $line_arr["place_name"];
  $datum = $line_arr["date"];
  $public = $line_arr["public"];
  if($last_id == NULL) {
    $sql = "INSERT INTO points (lat, lon, name, datum, visibility, userID) VALUES ('$latitude','$longitude','$jmeno','$datum','$public','$userID')";
  } else {

    $sql = "INSERT INTO points (lat, lon, name, datum, visibility, userID, collectionID) VALUES ('$latitude','$longitude','$jmeno','$datum','$public','$userID','$last_id')";
  }

    // pomoci try catch radeji kontrola jestli nedojde k nejake chybe
    // pokud by se z jakehokoliv duvodu vlozeni do db nepovedlo tak se smyčka ukončí a pošle chybové hlášení
  try {
    $vysledek = mysqli_query($pripoj, $sql);
    
  } catch (mysqli_sql_exception $e) {
    $response_array['status'] = false;
    $response_array['message'] = "Something went wrong";
    echo json_encode($response_array);
    break;
  }


}

// všechno proběhlo v pořádku a tak zprava succesfull message a odeslat a nakonec zavřít connection do databaze

$response_array['status'] = true;
$response_array['message'] = "The points have been saved successfully";

echo json_encode($response_array);

      

mysqli_close($pripoj);
?>