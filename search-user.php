<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
include("db-config.php");
// Try and connect using the info above.
$mysqli = mysqli_connect($servername, $username, $password, $dbname);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM accounts WHERE username LIKE ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();
            
            // Check number of rows in the result set
            if($result->num_rows > 0){
                // Fetch result rows as an associative array
                $response = "<table style='margin: 20px auto'>";
                $response .= "<thead><tr><td>User</td><td>Action</td></tr></thead><tbody>";

                while($row = $result->fetch_array(MYSQLI_ASSOC)){

                    $response .= "<tr data-id='".$row["id"]."'>";
                    $response .= "<td>" . $row["username"] . "</td>";
                    $response .= "<td><button class='show-user-collections' data-name='".$row['username']."' data-id='".$row['id']."'>Show their collections</button></td>";
                    $response .= "</tr>";
                }

                $response .= "</tbody></table>";

                echo $response;

            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    $stmt->close();
}
 
// Close connection
$mysqli->close();
?>