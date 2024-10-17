<?php
session_start();
require_once 'Database.php';
require_once 'classes/classVote.php';

$db = new Database();
$votingPage = new VotingPage($db);
$votingPage->displayCandidates();
?>
