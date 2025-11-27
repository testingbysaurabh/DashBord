<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "db.php";

$sql = "SELECT id, created_at FROM dashboard_layout ORDER BY id DESC LIMIT 20";
$result = $conn->query($sql);

$list = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $list[] = $row;
    }
}

echo json_encode($list);
$conn->close();
?>
