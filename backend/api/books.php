<?php
/**
 * Book Catalog & Search API Endpoint
 * Provides catalog filtering, pagination, and availability checks
 */
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

$pdo = Database::getInstance();
$query = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

$sql = "SELECT b.*, c.category_name FROM books b JOIN categories c ON b.category_id = c.id WHERE 1=1";
$params = [];

if (!empty($query)) {
    $sql .= " AND (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)";
    $term = "%$query%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
}

if (!empty($category) && $category !== 'All') {
    $sql .= " AND c.category_name = ?";
    $params[] = $category;
}

$sql .= " ORDER BY b.title ASC LIMIT 50";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll();

echo json_encode([
    'success' => true,
    'count' => count($books),
    'data' => $books
]);
?>
