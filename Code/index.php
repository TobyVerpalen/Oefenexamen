<?php
session_start();
require_once 'classes/classHomepage.php';

$homePage = new HomePage();
$homePage->render();
?>