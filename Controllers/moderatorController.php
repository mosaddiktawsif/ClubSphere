<?php
// Controllers/moderatorController.php
require_once('../Model/moderatorModel.php');
// Add your database connection file require here (e.g., require_once('../Model/db.php');)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'verify_match') {
        $matchId = $_POST['match_id'];
        $score = $_POST['score'];
        $status = $_POST['status']; // 'approved' or 'rejected'
        
        // Execute model function
        verifyMatchResult($conn, $matchId, $score, $status);
        header('Location: ../View/moderatorDashboard.php?msg=match_updated');
    }

    elseif ($action === 'add_inventory') {
        $itemName = $_POST['item_name'];
        $serialNumber = $_POST['serial_number'];
        $condition = $_POST['condition'];

        addInventoryItem($conn, $itemName, $serialNumber, $condition);
        header('Location: ../View/moderatorDashboard.php?msg=item_added');
    }

    elseif ($action === 'post_announcement') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $postedBy = $_SESSION['username'] ?? 'Moderator';

        createAnnouncement($conn, $title, $content, $postedBy);
        header('Location: ../View/moderatorDashboard.php?msg=announcement_posted');
    }
}
?>