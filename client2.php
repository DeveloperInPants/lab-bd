<?php
echo "<h2>client2: диагностика ошибок</h2>";

function run_query_with_error_report(PDO $pdo, string $sql): void {
    echo "<pre>";
    try {
        $affected = $pdo->exec($sql);   // для запросов без результата [web:159]
        echo "OK, затронуто строк: " . (int)$affected . "\n";
    } catch (PDOException $e) {
        echo "Ошибка выполнения запроса:\n";
        echo htmlspecialchars($e->getMessage()) . "\n";
    }
    echo "</pre>";
}

$sql = "SELECT 1"; // тестовый запрос
run_query_with_error_report($pdo, $sql);
