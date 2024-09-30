<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL password
$dbname = "login";

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure user is logged in by checking session data
if (!isset($_SESSION['email'])) {
    die("Error: You need to be logged in to create a tournament.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $name = $conn->real_escape_string($_POST['name']);
    $game = $conn->real_escape_string($_POST['game']);
    $type = $conn->real_escape_string($_POST['type']);
    $date = $conn->real_escape_string($_POST['date']);
    $slots = intval($_POST['slots']);
    $registration = $conn->real_escape_string($_POST['registration']);
    $prize = floatval($_POST['prize']);

    // Get the user email and username from the session
    $email = $_SESSION['email'];
    $username = $_SESSION['username']; // Storing the username in session

    // Handle file uploads
    $banner_paths = [];
    
    if (isset($_FILES['banners']) && !empty($_FILES['banners']['name'][0])) {
        $target_dir = "uploads/";

        // Create uploads directory if it doesn't exist
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        for ($i = 0; $i < count($_FILES['banners']['name']); $i++) {
            $file_name = basename($_FILES["banners"]["name"][$i]);
            $target_file = $target_dir . $file_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check for upload errors
            if ($_FILES["banners"]["error"][$i] !== UPLOAD_ERR_OK) {
                echo "Error uploading file " . $file_name . ": " . $_FILES["banners"]["error"][$i] . "<br>";
                continue;
            }

            // Check if file already exists

            // Check file size
            if ($_FILES["banners"]["size"][$i] > 500000) {
                echo "Sorry, your file " . $file_name . " is too large.<br>";
                continue;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                continue;
            }

            // Move uploaded file
            if (move_uploaded_file($_FILES["banners"]["tmp_name"][$i], $target_file)) {
                $banner_paths[] = $target_file; // Add the path to the array
                echo "The file " . htmlspecialchars($file_name) . " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your file " . $file_name . ".<br>";
            }
        }
    } else {
        echo "No files uploaded or there was an upload error.<br>";
    }

    if (!empty($banner_paths)) {
        // Convert the array of paths to a comma-separated string
        $banners = implode(",", $banner_paths);

        // Insert into tournaments table
        // Insert into tournaments table
        $stmt = $conn->prepare("INSERT INTO tournaments (name, game, type, date, slots, registration, prize, banner, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisiss", $name, $game, $type, $date, $slots, $registration, $prize, $banners, $email); // Ensure registration is bound as a string

        if ($stmt->execute()) {
            echo "New tournament created successfully";
            header("Location: tournaments.php"); // Redirect to display page
            exit;
        } else {
            echo "Error: " . $stmt->error; // Debugging error message
        }

        $stmt->close();
    } else {
        echo "No valid images were uploaded.<br>";
    }
}

$conn->close();
?>
