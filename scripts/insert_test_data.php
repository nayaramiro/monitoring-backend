<?php
// insert_test_data.php

$dbPath = __DIR__ . '/db/dashboard.sqlite';

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prépare la requête d'insertion
    $stmt = $pdo->prepare("INSERT INTO metrics (timestamp, value) VALUES (:timestamp, :value)");

    // Insérer plusieurs données de test
    for ($i = 0; $i < 5; $i++) {
        $stmt->execute([
            ':timestamp' => date('Y-m-d H:i:s', strtotime("-$i minutes")),
            ':value' => rand(50, 150),
        ]);
    }

    echo json_encode(['success' => true, 'message' => 'Données insérées avec succès !']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
