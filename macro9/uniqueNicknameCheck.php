<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// file path
$path = getcwd() . '/databases';

// open database
$db = new SQLite3($path . '/message.db');

// get POST data
$nickname = $_POST['nickname'];

// check for existing nickname
$sql = "SELECT COUNT(*) as count FROM active_users WHERE name = :nickname";
$statement = $db->prepare($sql);
$statement->bindParam(':nickname', $nickname);
$result = $statement->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

echo ($row['count'] > 0) ? 'false' : 'true';

?>