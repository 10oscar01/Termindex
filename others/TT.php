<?php
header('Content-Type: text/html; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "kone5566";
$dbname = "literatures";

// Create connection
//mysql_query("SET NAMES UTF8");
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM book WHERE MATCH (unitext) AGAINST ('4e00 65e5');";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " .$row["id"]. " Book_NO.:  " . $row["book_number"]." chapter: ".$row["chapter"]."<br>"." - realtext: " . $row["realtext"]."<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>