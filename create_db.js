const sqlite3 = require("sqlite3").verbose();
const path = require("path");

const dbPath = path.resolve(__dirname, "../db/dashboard.sqlite");
const db = new sqlite3.Database(dbPath);

db.serialize(() => {
  // Table metrics
  db.run(`
    CREATE TABLE IF NOT EXISTS metrics (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
      type TEXT NOT NULL,
      value REAL NOT NULL,
      page_or_endpoint TEXT,
      user_agent TEXT,
      context_json TEXT
    )
  `);

  // Table errors
  db.run(`
    CREATE TABLE IF NOT EXISTS errors (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
      type TEXT NOT NULL,
      message TEXT NOT NULL,
      stack_trace TEXT,
      source TEXT,
      context_json TEXT
    )
  `);

  // Table visual_anomalies
  db.run(`
    CREATE TABLE IF NOT EXISTS visual_anomalies (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
      page_url TEXT NOT NULL,
      diff_percentage REAL NOT NULL,
      baseline_image_path TEXT,
      diff_image_path TEXT,
      status TEXT DEFAULT 'new'
    )
  `);

  // Table rules
  db.run(`
    CREATE TABLE IF NOT EXISTS rules (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      name TEXT NOT NULL,
      metric_type TEXT NOT NULL,
      threshold REAL NOT NULL,
      operator TEXT NOT NULL,
      duration_seconds INTEGER NOT NULL,
      is_active INTEGER DEFAULT 1,
      severity TEXT DEFAULT 'medium',
      message_template TEXT
    )
  `);

  // Table alerts
  db.run(`
    CREATE TABLE IF NOT EXISTS alerts (
      id INTEGER PRIMARY KEY AUTOINCREMENT,
      rule_id INTEGER,
      timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
      type TEXT NOT NULL,
      message TEXT NOT NULL,
      severity TEXT NOT NULL,
      status TEXT DEFAULT 'active',
      details_json TEXT,
      resolved_at DATETIME,
      resolved_by TEXT,
      FOREIGN KEY (rule_id) REFERENCES rules(id)
    )
  `);

  console.log("Toutes les tables ont été créées (ou vérifiées).");
});

db.close();
