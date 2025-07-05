const express = require("express");
const sqlite3 = require("sqlite3").verbose();
const path = require("path");

const app = express();
const PORT = process.env.PORT || 8080;

// Chemin vers la base SQLite
const dbPath = path.resolve(__dirname, "../db/dashboard.sqlite");
const db = new sqlite3.Database(dbPath, (err) => {
  if (err) {
    console.error("Erreur lors de la connexion à la base SQLite:", err.message);
  } else {
    console.log("Connecté à la base SQLite.");
  }
});

// Middleware pour parser JSON
app.use(express.json());

// Route simple de test
app.get("/", (req, res) => {
  res.send("API Backend Monitoring Dashboard fonctionne !");
});

// Exemple de route pour récupérer les metrics
app.get("/metrics", (req, res) => {
  db.all(
    "SELECT * FROM metrics ORDER BY timestamp DESC LIMIT 20",
    [],
    (err, rows) => {
      if (err) {
        return res.status(500).json({ success: false, error: err.message });
      }
      res.json({ success: true, metrics: rows });
    }
  );
});

// Démarrer le serveur
app.listen(PORT, () => {
  console.log(`Serveur démarré sur http://localhost:${PORT}`);
});
