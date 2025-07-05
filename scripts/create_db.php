<?php
// backend/scripts/create_db.php

$dsn = getenv("DATABASE_URL") ?: "sqlite:" . __DIR__ . '/../db/dashboard.sqlite';
try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to DB successfully.";

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS metrics (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
            type TEXT NOT NULL,
            value REAL NOT NULL,
            page_or_endpoint TEXT,
            user_agent TEXT,
            context_json TEXT
        );
    ");
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
