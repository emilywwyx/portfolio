<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// file path
$path = getcwd() . '/databases';
$db = new SQLite3($path . '/message.db');

$name = $_POST['name'];
$message = $_POST['message'];
$roomID = $_POST['roomID'];
$ipAddress = $_SERVER['REMOTE_ADDR']; // Capture client IP Address

// make sure we have all values
if ($name && $message && $roomID) {
    $sql = "INSERT INTO messages (name, message, room_id) VALUES (:name, :message, :roomID)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':roomID', $roomID);
    $stmt->execute();

    // Log the action
    $logSql = "INSERT INTO system_logs (user, action, ip_address, timestamp) VALUES (:user, 'Sent a message', :ipAddress, datetime('now'))";
    $logStmt = $db->prepare($logSql);
    $logStmt->bindParam(':user', $name);
    $logStmt->bindParam(':ipAddress', $ipAddress);
    $logStmt->execute();

    echo "Message saved successfully";
} else {
    echo "ERROR";
}

$db->close();
?>
