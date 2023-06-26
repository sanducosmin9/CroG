<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);
$username = $data['username'];
$password = $data['password'];

$adminUsername = "admin";
$adminPassword = "password";

if ($username === $adminUsername && $password === $adminPassword) {
  session_start();
  $_SESSION["isAdminLoggedIn"] = true;

  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "message" => "Invalid credentials"]);
}
?>
