<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");


require_once "db.php";


$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data || !isset($data["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid payload"]);
    exit;
}


$id = intval($data["id"]);

$stmt = $conn->prepare("DELETE FROM dashboard_layout WHERE id = ?");
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "ok"]);
    } else {
        echo json_encode(["status" => "not_found"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to delete layout"]);
}

$stmt->close();
$conn->close();
?>
