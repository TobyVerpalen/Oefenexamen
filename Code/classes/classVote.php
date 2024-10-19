<?php
class VotingPage {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function displayCandidates() {
        // Check if the user is logged in; otherwise, redirect them to the login page
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        $conn = $this->db->getConnection();

        // Check if the user has already voted
        if ($this->hasUserVoted($_SESSION['user_id'])) {
            // Start de HTML-uitvoer
            echo "<!DOCTYPE html>";
            echo "<html>";
            echo "<head>";
            echo "<title>Stemmen</title>";
            echo "<link rel='stylesheet' href='css/index.css'>";
            echo "</head>";
            echo "<body>";

            // Navigatiebalk
            echo "<nav>";
            echo "<ul>";
            echo "<li><a href='index.php'>Startpagina</a></li>";
            echo "<li><a href='logout.php'>Log out</a></li>";
            echo "<li><a href='results.php'>Verkiezing resultaten</a></li>";
            echo "</ul>";
            echo "</nav>";

            echo "Je hebt al gestemd.";

            // Sluit de HTML-uitvoer
            echo "</body>";
            echo "</html>";

            return; // Exit early, preventing the user from voting again
        }

        // Display the list of candidates
        // Start de HTML-uitvoer
        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<title>Stemmen</title>";
        echo "<link rel='stylesheet' href='css/index.css'>";
        echo "</head>";
        echo "<body>";

        // Navigatiebalk
        echo "<nav>";
        echo "<ul>";
        echo "<li><a href='index.php'>Startpagina</a></li>";
        echo "<li><a href='logout.php'>Log out</a></li>";
        echo "</ul>";
        echo "</nav>";

        echo "<h2>Partijleiders</h2>";

        // Haal de lijst van partijleiders op uit de database inclusief de party_name
        $sqlCandidates = "SELECT * FROM party_leaders";
        $resultCandidates = $conn->query($sqlCandidates); // Voer de query uit en sla het resultaat op

        echo "<form method='POST' action=''>"; // Remove action attribute to submit to the same page

        while ($row = $resultCandidates->fetch(PDO::FETCH_ASSOC)) {
            $itemId = $row['id'];
            $itemName = $row['name'];
            $partyName = $row['party_name'];

            echo "<label>";
            echo "<input type='radio' name='candidate_id' value='$itemId'>";
            echo "$itemName ($partyName)";
            echo "</label><br>";
        }

        echo "<button type='submit' name='submit'>Stem</button>";
        echo "</form>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $selectedCandidateId = $_POST['candidate_id'];
            $this->recordVote($_SESSION['user_id'], $selectedCandidateId);
            header('Location: voted.php');
            exit;
        }

        echo "<p><a href='logout.php'>Log out</a></p>";

        // Sluit de HTML-uitvoer
        echo "</body>";
        echo "</html>";
    }

    // Check if the user has already voted
    private function hasUserVoted($userId) {
        $conn = $this->db->getConnection();
        $sqlCheckVote = "SELECT COUNT(*) FROM votes WHERE user_id = :user_id";
        $stmt = $conn->prepare($sqlCheckVote);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $voteCount = $stmt->fetchColumn();
        return $voteCount > 0;
    }

    // The recordVote method should be defined only once in this class
    public function recordVote($userId, $candidateId) {
        $conn = $this->db->getConnection();

        // Prepare an SQL statement to insert the vote
        $sqlInsertVote = "INSERT INTO votes (user_id, candidate_id) VALUES (:user_id, :candidate_id)";
        $stmt = $conn->prepare($sqlInsertVote);

        // Bind parameters
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':candidate_id', $candidateId, PDO::PARAM_INT);

        // Execute the insert statement
        $stmt->execute();

        // Store the selected candidate's information in the session
        $_SESSION['selected_candidate_id'] = $candidateId;
    }
}
?>
