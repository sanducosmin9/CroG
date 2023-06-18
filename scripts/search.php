<?php
include 'db_connection.php';
include 'keywords.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$searchData = json_decode(file_get_contents('php://input'), true);
$searchPrompt = $searchData['search'];
$languages = $searchData['languages'];
$artisticStyles = $searchData['artisticStyles'];
$waysOfInteraction = $searchData['waysOfInteraction'];

function generateSearchQuery($languages, $artisticStyles, $wayOfInteractions, $prompt, $keywords)
{
    $where = '';

    if (!empty($languages)) {
        $languageConditions = [];
        foreach ($languages as $language) {
            $languageConditions[] = "(name LIKE '%$language%' OR description LIKE '%$language%')";
        }
        $where .= '(' . implode(' OR ', $languageConditions) . ')';
    }

    if (!empty($artisticStyles)) {
        if (!empty($where)) {
            $where .= ' AND ';
        }
        $artisticStyleConditions = [];
        foreach ($artisticStyles as $artisticStyle) {
            $artisticStyleConditions[] = "(name LIKE '%$artisticStyle%' OR description LIKE '%$artisticStyle%')";
        }
        $where .= '(' . implode(' OR ', $artisticStyleConditions) . ')';
    }

    if (!empty($wayOfInteractions)) {
        if (!empty($where)) {
            $where .= ' AND ';
        }
        $wayOfInteractionConditions = [];
        foreach ($wayOfInteractions as $wayOfInteraction) {
            $wayOfInteractionConditions[] = "(name LIKE '%$wayOfInteraction%' OR description LIKE '%$wayOfInteraction%')";
        }
        $where .= '(' . implode(' OR ', $wayOfInteractionConditions) . ')';
    }

    $promptQuery = generateQueryBasedOnPrompt($prompt, $keywords);
    $query = "SELECT * FROM resources";
    if (!empty($where) && !empty($promptQuery)) {
        $query .= " WHERE $where";
        $query .= " AND (" . implode(' OR ', $promptQuery) . ");";
    } else if (!empty($where)) {
        $query .= " WHERE $where;";
    } else if (!empty($promptQuery)) {
        $query .= " WHERE " . implode(' OR ', $promptQuery) . ";";
    } else {
        $query .= " LIMIT 10;";
    }
    return $query;
}

function generateQueryBasedOnPrompt($prompt, $keywords)
{
    $prompt = strtolower($prompt);
    $promptKeywords = explode(' ', $prompt);
    $keywords = getKeywords();
    $conditions = [];
    foreach ($promptKeywords as $keyword) {
        if (in_array($keyword, $keywords)) {
            $conditions[] = "name LIKE '%$keyword%' OR description LIKE '%$keyword%'";
        }
    }
    return $conditions;
}

function performQuery($query)
{
    $pdo = openConnection();

    $statement = $pdo->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;

    return $results;
}

$query = generateSearchQuery($languages, $artisticStyles, $waysOfInteraction, $searchPrompt, getKeywords());
echo json_encode(performQuery($query));

?>