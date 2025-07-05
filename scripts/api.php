<?php
header('Content-Type: application/json');

$dbPath = __DIR__ . '/../../db/dashboard.sqlite';

echo json_encode([
    'path' => $dbPath,
    'exists' => file_exists($dbPath),
    'is_writable' => is_writable(dirname($dbPath)),
    'is_readable' => is_readable($dbPath),
]);

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM metrics ORDER BY timestamp DESC LIMIT 20");
    $metrics = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'metrics' => $metrics,
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
}
