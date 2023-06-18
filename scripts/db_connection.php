<?php
function openConnection()
{
    $dbhost = "localhost";
    $dbuser = "postgres";
    $dbpass = "postgres";
    $dbname = "CroG";
    $dbport = "5436";

    try {
        $dsn = "pgsql:host=$dbhost;port=$dbport;dbname=$dbname";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $dbconn = new PDO($dsn, $dbuser, $dbpass, $options);
        return $dbconn;
    } catch (PDOException $e) {
        exit;
    }
}

function closeConnection($conn)
{
    $conn->close();
}

?>