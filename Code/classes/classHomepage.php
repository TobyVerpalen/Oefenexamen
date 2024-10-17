<?php
class HomePage {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }
    }

    public function render() {
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<title>Home</title>";
        echo "<link rel='stylesheet' href='css/index.css'>"; // Aanhalingstekens binnen een tekenreeks ontsnapt
        echo "</head>";
        echo "<body>";

        // Navigatiebalk
        echo "<nav>";
        echo "<ul>";
        echo "<li><a href='index.php'>Home</a></li>";
        echo "<li><a href='vote.php'>Stemmen</a></li>";
        echo "<li><a href='reset_password.php'>Reset password</a></li>";
        echo "<li><a href='logout.php'>Log out</a></li>";
        echo "<li><a href='information.php'>Informatie</a></li>";
        echo "</ul>";
        echo "</nav>";

        echo "<h2>Home</h2>";
        echo "<p>Hello, you are logged in.</p>";
        echo "</body>";
        echo "</html>";
    }    
}
?>
