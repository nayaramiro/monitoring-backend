<?php
// backend/scripts/test_api.php

// Chemin vers la base SQLite
$dbPath = __DIR__ . '/../../db/dashboard.sqlite';

echo "Chemin base: $dbPath\n";
echo "Fichier existe ? " . (file_exists($dbPath) ? "Oui" : "Non") . "\n";

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test de récupération des tables
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Tables :\n";
    print_r($tables);
} catch (Exception $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
