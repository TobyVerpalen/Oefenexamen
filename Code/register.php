<?php
session_start();
require_once 'Database.php';
require_once 'classes/classUser.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registratie</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <!-- Navigatiebalk -->
    <nav>
        <ul>
            <li><a href="index.php">Startpagina</a></li>
        </ul>
    </nav>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = new Database();
        $user = new User($db->getConnection());

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->register($username, $email, $password)) {
            header('Location: login.php');
            exit;
        } else {
            echo "Registratie mislukt.";
        }
    }
    ?>