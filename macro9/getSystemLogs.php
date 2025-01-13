<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$path = getcwd() . '/databases';
$db = new SQLite3($path . '/message.db');

// Fetch logs
$sql = "SELECT user, action, ip_address, timestamp FROM system_logs ORDER BY timestamp DESC";
$result = $db->query($sql);

echo "<h2>System Usage Logs</h2>";
echo "<ul>";
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo "<li>{$row['timestamp']} - {$row['user']} (IP: {$row['ip_address']}) performed: {$row['action']}</li>";
}
echo "</ul>";

$db->close();
?>
