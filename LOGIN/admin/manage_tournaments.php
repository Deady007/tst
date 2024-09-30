<?php
// Include database connection
include '../config.php';

// Fetch tournaments from the database
$tournaments = $conn->query("SELECT * FROM tournaments");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <title>Tournament List</title>
</head>
<body>

<h1>Tournament List</h1>

<?php
if ($tournaments->num_rows > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Name</th>';
    echo '<th>Start Date</th>';
    echo '<th>End Date</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Iterate through each tournament
    while ($tournament = $tournaments->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($tournament['tournament_id']) . '</td>'; // Tournament ID
        echo '<td>' . (isset($tournament['name']) ? htmlspecialchars($tournament['name']) : 'N/A') . '</td>'; // Tournament name
        echo '<td>' . (isset($tournament['start_date']) ? htmlspecialchars($tournament['date']) : 'N/A') . '</td>'; // Start date
        echo '<td>' . (isset($tournament['end_date']) ? htmlspecialchars($tournament['registration']) : 'N/A') . '</td>'; // End date
        echo '<td><a href="delete_tournament.php?id=' . htmlspecialchars($tournament['tournament_id']) . '">Delete</a></td>'; // Delete link
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No tournaments available to display.</p>';
}
?>

</body>
</html>
