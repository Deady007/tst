<?php
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "login";   // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$tournament_id = $_POST['tournament_id'];
$name = $_POST['name'];
$game = $_POST['game'];
$type = $_POST['type'];
$date = $_POST['date'];
$slots = $_POST['slots'];
$registration = $_POST['registration'];
$prize = $_POST['prize'];

// Handle file upload
$banner = $_FILES['banner'];
$banner_path = "";

if ($banner['size'] > 0) {
    // File was uploaded
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($banner["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image
    $check = getimagesize($banner["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($banner["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($banner["tmp_name"], $target_file)) {
            $banner_path = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Update the tournament in the database
$sql = "UPDATE tournaments SET name=?, game=?, type=?, date=?, slots=?, registration=?, prize=?";
$params = [$name, $game, $type, $date, $slots, $registration, $prize];

// Append banner path if a new file was uploaded
if (!empty($banner_path)) {
    $sql .= ", banner=?";
    $params[] = $banner_path;
}

$sql .= " WHERE tournament_id=?";
$params[] = $tournament_id;

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);

if ($stmt->execute()) {
    // Redirect to tournaments.php after a successful update
    header("Location: tournaments.php");
    exit; // Ensure no further code is executed after the redirect
} else {
    echo "Error updating tournament: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
