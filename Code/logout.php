<?php
// Start de sessie
session_start();

// Vernietig alle sessievariabelen
session_destroy();

// Stuur de gebruiker naar de inlogpagina
header('Location: login.php');
exit;
?>
