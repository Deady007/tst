<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Tournament</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <img src="logo.png" alt="Furious eSports Logo" class="logo">
    </header>
    <main>
        <form id="tournament-form" action="update.php" method="post" enctype="multipart/form-data">
            <!-- Dropdown to select tournament -->
            <label for="tournament_id">Select Tournament:</label>
            <select id="tournament_id" name="tournament_id" required>
                <option value="">--Select a Tournament--</option>
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

                // Fetch all tournaments to populate the dropdown
                $allTournamentsSql = "SELECT tournament_id, name FROM tournaments";
                $allTournamentsResult = $conn->query($allTournamentsSql);
                
                if ($allTournamentsResult->num_rows > 0) {
                    while ($row = $allTournamentsResult->fetch_assoc()) {
                        echo '<option value="' . $row['tournament_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                    }
                } else {
                    echo '<option value="">No tournaments available</option>';
                }
                ?>
            </select><br>

            <label for="name">Tournament Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="game">Game:</label>
            <input type="text" id="game" name="game" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>

            <label for="slots">Slots Available:</label>
            <input type="number" id="slots" name="slots" required><br>

            <label for="registration">Registration Deadline:</label>
            <input type="date" id="registration" name="registration" required><br>

            <label for="prize">Prize Pool:</label>
            <input type="number" id="prize" name="prize" required><br>

            <label for="banner">Tournament Banner:</label>
            <input type="file" id="banner" name="banner"><br>
            <small>Leave blank to keep the existing banner</small><br>

            <input type="submit" value="Update Tournament">
        </form>

        <?php
        // Close the connection
        $conn->close();
        ?>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>

    <script>
        // Function to fetch tournament details using AJAX
        $(document).ready(function() {
            $('#tournament_id').change(function() {
                var tournamentID = $(this).val();

                if (tournamentID) {
                    $.ajax({
                        url: 'get_tournament_details.php',
                        type: 'POST',
                        data: { tournament_id: tournamentID },
                        dataType: 'json',
                        success: function(response) {
                            if (response) {
                                $('#name').val(response.name);
                                $('#game').val(response.game);
                                $('#type').val(response.type);
                                $('#date').val(response.date);
                                $('#slots').val(response.slots);
                                $('#registration').val(response.registration);
                                $('#prize').val(response.prize);
                            } else {
                                alert("Tournament details not found.");
                            }
                        },
                        error: function() {
                            alert("Error retrieving tournament details.");
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
