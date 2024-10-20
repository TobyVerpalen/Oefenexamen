<?php
session_start();
require_once 'Database.php';
require_once 'classes/classInformation.php';

$db = new Database();
$partiesPage = new PartiesPage($db);
$partiesPage->displayPartyInfo();
?>
