<?php
require_once __DIR__ . '/connect.php';

header('Content-Type: application/json');

$term = $_GET['term'] ?? '';
if (empty($term)) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT title FROM products WHERE title LIKE :term LIMIT 10";
$stmt = $pdo->prepare($sql);
$searchTerm = $term . '%';  // для автодоповнення — шукаємо за початком слова
$stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($results);
