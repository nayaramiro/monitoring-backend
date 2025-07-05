<?php
$db = new PDO('sqlite:../db/dashboard.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $db->prepare("INSERT INTO metrics (timestamp, value) VALUES (:timestamp, :value)");
$stmt->execute([
  ':timestamp' => date('Y-m-d H:i:s'),
  ':value' => rand(10, 100)
]);

echo "Échantillon inséré avec succès.\n";
?>
