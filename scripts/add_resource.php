<?php
include 'db_connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$formData = json_decode(file_get_contents('php://input'), true);

// Get the form data
$title = $formData['title'];
$resourceType = $formData['type'];
$resourceSubType = $formData['subtype'];
$link = $formData['link'];
$description = $formData['description'];

$pdo = openConnection();

// Prepare the SQL statement
$statement = $pdo->prepare("INSERT INTO resources (name, description, link, type, subtype) VALUES (?, ?, ?, ?, ?)");

// Bind the values
$statement->bindValue(1, $title);
$statement->bindValue(2, $description);
$statement->bindValue(3, $link);
$statement->bindValue(4, $resourceType);
$statement->bindValue(5, $resourceSubType);

// Execute the statement
$statement->execute();


?>