<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$dbPath = __DIR__ . '/db/dashboard.sqlite';

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

if (!file_exists($dbPath)) {
    echo json_encode([
        'success' => false,
        'error' => "Fichier de base de données non trouvé à : $dbPath"
    ]);
    exit;
}

