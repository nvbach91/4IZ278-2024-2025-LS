<?php
require_once __DIR__ . '/../../app/models/ConceptDB.php';
header('Content-Type: application/json');

$q = $_GET['q'] ?? '';
$conceptDB = new ConceptDB();
$results = [];

if ($q !== '') {
    $results = $conceptDB->search($q);
}

$formatted = array_map(function ($row) {
    $text = $row['name'];

    if (!empty($row['description'])) {
        $text .= " [" . $row['description'] . "]";
    }

    return [
        'id' => $row['concept_id'],
        'text' => $text
    ];
}, $results);

echo json_encode($formatted);
?>