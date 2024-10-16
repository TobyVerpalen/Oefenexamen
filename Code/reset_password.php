<?php
session_start();
require_once 'Database.php';
require_once 'classes/classUser.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verkrijg het nieuwe wachtwoord uit het formulier
    $new_password = $_POST['new_password'];

    // Maak een databaseverbinding
    $db = new Database();
    $user = new User($db->getConnection());

    // Reset het wachtwoord voor de ingelogde gebruiker
    if ($user->resetPassword($_SESSION['user_id'], $new_password)) {
        echo "Wachtwoord is gereset. <a href='login.php'>Log in</a>.";
        exit;
    } else {
        echo "Er is een fout opgetreden bij het resetten van het wachtwoord.";
    }
} else {
    // Toon het wachtwoordresetformulier met een invoerveld voor nieuw wachtwoord
    echo "<h2>Reset Password</h2>";
    echo "<form method='POST' action='reset_password.php'>";
    echo "New Password: <input type='password' name='new_password' required><br><br>";
    echo "<button type='submit'>Reset Password</button>";
    echo "</form>";
}
?>
