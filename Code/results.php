<?php
session_start();
require_once 'Database.php';
require_once 'classes/classResults.php';

$db = new Database();
$resultsPage = new ResultsPage($db);
$resultsPage->displayElectionResults();
?>
