<?php
include 'db_connection.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type");

class ItemService
{
    public function deleteItem($itemId)
    {
        $result_code = false;
        $pdo = OpenConnection();

        $statement = $pdo->prepare('DELETE FROM resources WHERE id = ?');

        $statement->bindValue(1, $itemId);

        if ($statement->execute()) {
            $result_code = true;
        }

        $pdo = null;

        return $result_code;
    }

    public function updateItem($itemId, $requestData)
    {
        $success = false;
        $pdo = OpenConnection();

        $statement = $pdo->prepare('UPDATE resources SET name = ?, description = ?, link = ? WHERE id = ?');

        $statement->bindValue(1, $requestData['title']);
        $statement->bindValue(2, $requestData['description']);
        $statement->bindValue(3, $requestData['link']);
        $statement->bindValue(4, $itemId);

        if ($statement->execute()) {
            $success = true;
        }
        
        $pdo->close();

        return $success;
    }
}

?>
