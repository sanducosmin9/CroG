<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once('item_service.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $itemId = $_GET['id'];

    $itemService = new ItemService();
    $result = $itemService->deleteItem($itemId);

    if ($result) {
        http_response_code(204);
        echo 'Item deleted successfully.';
    } else {
        http_response_code(500);
        echo 'Failed to delete item.';
    }

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $itemId = $_GET['id'];

    $requestData = json_decode(file_get_contents('php://input'), true);

    $itemService = new ItemService();
    $result = $itemService->updateItem($itemId, $requestData);

    if ($result) {
        http_response_code(200);
        echo 'Item updated successfully.';
    } else {
        http_response_code(500);
        echo 'Failed to update item.';
    }

    exit;
}


?>
