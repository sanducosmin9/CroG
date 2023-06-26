<?php
include 'db_connection.php';

$pdo = OpenConnection();

// Read the contents of the Markdown file
$markdown = file_get_contents('../resources/readme.md');

// Split the Markdown content into lines
$lines = explode("\n", $markdown);

// Create an empty array to store the extracted objects
$objects = [];

// Initialize variables to keep track of the current type and subtype
$currentType = '';
$currentSubtype = '';

// Iterate over each line in the Markdown content
foreach ($lines as $line) {
    // Check if the line represents a type heading
    if (preg_match('/^##\s+(.*?)$/', $line, $matches)) {
        $currentType = $matches[1];
    }

    // Check if the line represents a subtype heading
    if (preg_match('/^###\s+(.*?)$/', $line, $matches)) {
        $currentSubtype = $matches[1];
    }

    // Check if the line represents an object item
    if (preg_match('/^- \[(.*?)\]\((.*?)\)(.*?)$/', $line, $matches)) {
        $name = trim($matches[1]);
        $link = trim($matches[2]);
        $description = trim($matches[3]);
        $description = str_replace('- ', '', $description);

        // Create an object with the extracted information
        $object = [
            'id' => count($objects) + 1,
            'name' => $name,
            'description' => $description,
            'link' => $link,
            'type' => $currentType,
            'subtype' => $currentSubtype
        ];

        // Add the object to the array
        $objects[] = $object;
    }
}

// Output the extracted objects
foreach ($objects as $object) {
    $name = $object['name'];
    $description = $object['description'];
    $link = $object['link'];
    $type = $object['type'];
    $subtype = $object['subtype'];

    // Prepare the SQL statement
    $statement = $pdo->prepare("INSERT INTO resources (name, description, link, type, subtype) VALUES (?, ?, ?, ?, ?)");

    // Bind the values
    $statement->bindValue(1, $name);
    $statement->bindValue(2, $description);
    $statement->bindValue(3, $link);
    $statement->bindValue(4, $type);
    $statement->bindValue(5, $subtype);

    // Execute the statement
    $statement->execute();
}

?>