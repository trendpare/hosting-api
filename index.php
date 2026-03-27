<?php

require_once "config.php";

header("Content-Type: application/json");

// API KEY kontrol
if (!isset($_GET['key']) || $_GET['key'] !== API_KEY) {
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$action = $_GET['action'] ?? null;

$file = "users.json";
$data = json_decode(file_get_contents($file), true);

if (!$data) {
    $data = [];
}

// CREATE USER
if ($action === "create") {
    $username = $_GET['username'] ?? null;
    $package = $_GET['package'] ?? null;

    if (!$username || !$package) {
        echo json_encode(["error" => "Missing parameters"]);
        exit;
    }

    $newUser = [
        "username" => $username,
        "package" => $package,
        "created_at" => date("Y-m-d H:i:s")
    ];

    $data[] = $newUser;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode(["success" => true, "user" => $newUser]);
    exit;
}

// LIST USERS
if ($action === "list") {
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

// DEFAULT
echo json_encode(["error" => "Invalid action"]);