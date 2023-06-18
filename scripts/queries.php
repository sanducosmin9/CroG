<?php
include 'db_connection.php';
include 'keywords.php';

$searchData = json_decode(file_get_contents('php://input'), true);
$searchPrompt = $searchData['search'];
$languages = $searchData['languages'];
$artisticStyles = $searchData['artisticStyles'];
$waysOfInteraction = $searchData['waysOfInteraction'];

function generateSearchQuery($languages, $artisticStyles, $wayOfInteractions, $prompt, $keywords)
{
    // Initialize the WHERE clause
    $where = '';

    // Add conditions for languages
    if (!empty($languages)) {
        $languageConditions = [];
        foreach ($languages as $language) {
            $languageConditions[] = "(name LIKE '%$language%' OR description LIKE '%$language%')";
        }
        $where .= '(' . implode(' OR ', $languageConditions) . ')';
    }

    // Add conditions for artistic styles
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

    // Add conditions for way of interactions
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
    if (!empty($where)) {
        $query .= " WHERE $where";
        $query .= " AND (" . implode(' OR ', $promptQuery) . ");";
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

$query = generateSearchQuery($languages, $artisticStyles, $waysOfInteraction, $searchPrompt, getKeywords());
echo json_encode($query);

?>