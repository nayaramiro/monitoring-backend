<?php
$dbPath = __DIR__ . '/../db/dashboard.sqlite';

if (!file_exists($dbPath)) {
    die("Erreur : fichier SQLite introuvable à l'emplacement $dbPath");
}

try {
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO metrics (timestamp, value, type) VALUES (:timestamp, :value, :type)";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':timestamp' => date('Y-m-d H:i:s'),
    ':value' => rand(0, 100),
    ':type' => 'default',  // ou un autre type valide selon ta table
]);


    echo "Insertion réussie.\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
