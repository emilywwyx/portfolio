<?php
// Get the chat room ID
$roomID = $_POST['roomID'];

// Open the database
$db = new SQLite3('databases/message.db');

// Delete messages for the specified room
$sql = "DELETE FROM messages WHERE room_id = :roomID";
$stmt = $db->prepare($sql);
$stmt->bindParam(':roomID', $roomID);
$stmt->execute();

// Close the database
$db->close();
echo 'Chat cleared';
?>