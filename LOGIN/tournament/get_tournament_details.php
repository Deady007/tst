<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if tournament_id is passed
if (isset($_POST['tournament_id'])) {
    $tournament_id = $_POST['tournament_id'];

    // Prepare the SQL query
    $sql = "SELECT * FROM tournaments WHERE tournament_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tournament_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch tournament details
        $row = $result->fetch_assoc();
        // Return the data as a JSON object
        echo json_encode($row);
    } else {
        echo json_encode(null);
    }

    $stmt->close();
}

$conn->close();
?>
