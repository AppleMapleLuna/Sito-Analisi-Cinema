<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../database/connessione_db.php';

$film_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($film_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID film non valido']);
    exit;
}

$stmt = $conn->prepare("
    SELECT 
        COUNT(*) AS num_recensioni,
        AVG(Voto) AS voto_medio,
        SUM(CASE WHEN Voto BETWEEN 1 AND 2 THEN 1 ELSE 0 END) AS voti_1_2,
        SUM(CASE WHEN Voto BETWEEN 3 AND 4 THEN 1 ELSE 0 END) AS voti_3_4,
        SUM(CASE WHEN Voto BETWEEN 5 AND 6 THEN 1 ELSE 0 END) AS voti_5_6,
        SUM(CASE WHEN Voto BETWEEN 7 AND 8 THEN 1 ELSE 0 END) AS voti_7_8,
        SUM(CASE WHEN Voto BETWEEN 9 AND 10 THEN 1 ELSE 0 END) AS voti_9_10
    FROM valutazioni
    WHERE ID_Film = ?
");
$stmt->bind_param("i", $film_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

$num_recensioni = (int)($stats['num_recensioni'] ?? 0);
$voto_medio = $num_recensioni > 0 ? round($stats['voto_medio'], 1) : null;

$distribuzione = [
    '1-2'   => (int)($stats['voti_1_2'] ?? 0),
    '3-4'   => (int)($stats['voti_3_4'] ?? 0),
    '5-6'   => (int)($stats['voti_5_6'] ?? 0),
    '7-8'   => (int)($stats['voti_7_8'] ?? 0),
    '9-10'  => (int)($stats['voti_9_10'] ?? 0)
];

echo json_encode([
    'success' => true,
    'stats' => [
        'num_recensioni' => $num_recensioni,
        'voto_medio' => $voto_medio,
        'distribuzione' => $distribuzione
    ]
]);