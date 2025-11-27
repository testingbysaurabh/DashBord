<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

require_once "db.php";

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data || !isset($data["layout"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid payload"]);
    exit;
}

$layoutJson = json_encode($data["layout"]);

$stmt = $conn->prepare("INSERT INTO dashboard_layout (layout_json) VALUES (?)");
$stmt->bind_param("s", $layoutJson);

if ($stmt->execute()) {
    echo json_encode(["status" => "ok", "id" => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to save layout"]);
}

$stmt->close();
$conn->close();
?>
