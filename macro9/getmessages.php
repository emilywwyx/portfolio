<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database file path
$path = getcwd() . '/databases';
$db = new SQLite3($path . '/message.db');

// Retrieve room ID from GET request
$roomID = $_GET['roomID'];

// Prepare and execute the query
$sql = "SELECT * FROM messages WHERE room_id = :roomID ORDER BY id";
$statement = $db->prepare($sql);
$statement->bindParam(':roomID', $roomID);
$result = $statement->execute();

// Fetch all messages
$send_back = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $send_back[] = $row;
}

// Close the database
$db->close();
echo json_encode($send_back);
?>