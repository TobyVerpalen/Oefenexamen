<?php
session_start();
require_once 'Database.php';
require_once 'classes/classUser.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Inloggen</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Navigatiebalk -->
    <nav>
        <ul>
            <li><a href="index.php">Startpagina</a></li>
            <li><a href="register.php">Registreren</a></li>
        </ul>
    </nav>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $db = new Database();
        $user = new User($db->getConnection());

        $logged_in_user = $user->login($username, $password);

        if ($logged_in_user) {
            $_SESSION['user_id'] = $logged_in_user['id'];
            echo "Inloggen gelukt. Welkom, " . $logged_in_user['username'] . "!<br>";
            echo "<br>";
            echo "<a href='reset_password.php'>Wachtwoord vergeten?</a><br>";
            echo "<a href='vote.php'>Stem op kandidaten</a>"; // Voeg de link naar de vote-pagina toe
        } else {
            echo "Inloggen mislukt. Controleer je gebruikersnaam en wachtwoord.";
        }
    } else {
        // Toon het inlogformulier
        echo "<h2>Inloggen</h2>";
        echo "<form method='POST' action='login.php'>";
        echo "Gebruikersnaam: <input type='text' name='username' required><br><br>";
        echo "Wachtwoord: <input type='password' name='password' required><br><br>";
        echo "<button type='submit'>Inloggen</button>";
        echo "</form>";
    }
    ?>
</body>
</html>
