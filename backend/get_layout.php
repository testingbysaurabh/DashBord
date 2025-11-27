<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "db.php";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

if ($id) {
    $stmt = $conn->prepare("SELECT id, layout_json, created_at FROM dashboard_layout WHERE id = ?");
    $stmt->bind_param("i", $id);
} else {
    $stmt = $conn->prepare("SELECT id, layout_json, created_at FROM dashboard_layout ORDER BY id DESC LIMIT 1");
}

$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["layout_json" => null]);
}

$stmt->close();
$conn->close();
?>
