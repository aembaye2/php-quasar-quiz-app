<?php
$db = new SQLite3(__DIR__ . '/db.sqlite');

$db->exec("CREATE TABLE IF NOT EXISTS todos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    text TEXT NOT NULL,
    done INTEGER DEFAULT 0
)");

echo "Database and table ready.\n";

