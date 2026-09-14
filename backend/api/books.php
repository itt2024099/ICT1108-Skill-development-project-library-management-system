<?php
// Book Search & Catalog API Endpoint
// filter books by title, auther or category
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';

// Get search query and category from URL parameters
$query = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');

// Base SQL query joining books and categories
$sql = "SELECT b.*, c.category_name FROM books b JOIN categories c ON b.category_id = c.id WHERE 1=1";
$params = [];

// Filter by search text (title, author, or isbn)
if (!empty($query)) {
    $sql .= " AND (b.title LIKE ? OR b.author LIKE ? OR b.isbn LIKE ?)";
    $term = "%$query%";
    $params[] = $term;
    $params[] = $term;
    $params[] = $term;
}

// Filter by book category
if (!empty($category) && $category !== 'All') {
    $sql .= " AND c.category_name = ?";
    $params[] = $category;
}

// Sort alphabetically by book title
$sql .= " ORDER BY b.title ASC LIMIT 50";

// Execute prepared statement
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll();

// Return results as JSON
echo json_encode([
    'success' => true,
    'count' => count($books),
    'data' => $books
]);
?>