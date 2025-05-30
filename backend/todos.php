<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$db = new SQLite3(__DIR__ . '/db.sqlite');

// GET: List todos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->query("SELECT * FROM todos ORDER BY id DESC");
    $todos = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $row['done'] = (bool) $row['done'];
        $todos[] = $row;
    }
    echo json_encode($todos);
    exit;
}

// POST: Add new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $text = trim($data['text'] ?? '');
    if (!$text) {
        http_response_code(400);
        echo json_encode(['error' => 'Text is required']);
        exit;
    }
    $stmt = $db->prepare("INSERT INTO todos (text) VALUES (:text)");
    $stmt->bindValue(':text', $text);
    $stmt->execute();
    $id = $db->lastInsertRowID();
    echo json_encode(['id' => $id, 'text' => $text, 'done' => false]);
    exit;
}

// DELETE: Delete todo
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $query);
    $id = $query['id'] ?? null;
    if (!$id || !is_numeric($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid ID']);
        exit;
    }
    $stmt = $db->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
    exit;
}
