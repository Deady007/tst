<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tournament</title>
    <link rel="stylesheet" href="style.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tournamentDateInput = document.getElementById('date');
            const registrationDateInput = document.getElementById('registration');

            // Add an event listener to validate the registration date
            registrationDateInput.addEventListener('change', function() {
                const tournamentDate = new Date(tournamentDateInput.value);
                const registrationDate = new Date(registrationDateInput.value);

                if (registrationDate > tournamentDate) {
                    alert("Registration deadline cannot be later than the tournament date.");
                    registrationDateInput.value = ""; // Reset the invalid input
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <img src="logo.png" alt="Furious eSports Logo" class="logo">
    </header>
    <main>
        <form action="connect.php" method="post" enctype="multipart/form-data">
            <label for="name">Tournament Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="game">Game:</label>
            <input type="text" id="game" name="game" required><br>

            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>

            <label for="date">Tournament Date:</label>
            <input type="date" id="date" name="date" required><br>

            <label for="slots">Slots Available:</label>
            <input type="number" id="slots" name="slots" required><br>

            <label for="registration">Registration Deadline:</label>
            <input type="date" id="registration" name="registration" required><br>

            <label for="prize">Prize Pool:</label>
            <input type="number" id="prize" name="prize" required><br>

            <label for="banners">Tournament Banner:</label>
            <input type="file" id="banners" name="banners[]" multiple required><br>

            <input type="submit" value="Create Tournament">
        </form>
    </main>
    <footer>
        <p>Managed By Furious eSports</p>
    </footer>
</body>
</html>
