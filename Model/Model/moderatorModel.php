<?php
// Model/moderatorModel.php

// 1. Match Result Verification Models
function getPendingMatchResults($conn) {
    $sql = "SELECT * FROM match_submissions WHERE status = 'pending'";
    return mysqli_query($conn, $sql);
}

function verifyMatchResult($conn, $matchId, $score, $status) {
    $sql = "UPDATE match_submissions SET score = '$score', status = '$status' WHERE match_id = $matchId";
    return mysqli_query($conn, $sql);
}

// 2. Inventory Tracking Models
function addInventoryItem($conn, $itemName, $serialNumber, $conditionStatus) {
    $sql = "INSERT INTO inventory (item_name, serial_number, condition_status) VALUES ('$itemName', '$serialNumber', '$conditionStatus')";
    return mysqli_query($conn, $sql);
}

function assignInventoryItem($conn, $itemId, $assignedMemberId) {
    $sql = "UPDATE inventory SET assigned_to = '$assignedMemberId' WHERE id = $itemId";
    return mysqli_query($conn, $sql);
}

function updateItemCondition($conn, $itemId, $conditionStatus) {
    $sql = "UPDATE inventory SET condition_status = '$conditionStatus' WHERE id = $itemId";
    return mysqli_query($conn, $sql);
}

function getAllInventory($conn) {
    $sql = "SELECT * FROM inventory";
    return mysqli_query($conn, $sql);
}

// 3. Announcement Broadcasting Models
function createAnnouncement($conn, $title, $content, $postedBy) {
    $sql = "INSERT INTO announcements (title, content, posted_by, date_posted) VALUES ('$title', '$content', '$postedBy', NOW())";
    return mysqli_query($conn, $sql);
}
?>