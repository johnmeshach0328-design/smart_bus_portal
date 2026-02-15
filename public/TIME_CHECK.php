<?php
require_once 'db.php';
echo "PHP Time: " . date('Y-m-d H:i:s') . " (" . time() . ")<br>";
$res = $conn->query("SELECT NOW() as db_now");
$row = $res->fetch_assoc();
echo "MySQL Time: " . $row['db_now'] . " (" . strtotime($row['db_now']) . ")<br>";
echo "Difference (seconds): " . (time() - strtotime($row['db_now'])) . "<br>";
?>