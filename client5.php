<?php
echo "<h2>client5: общий запрос</h2>";

$resultText = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $_POST['sql'] ?? '';

    if ($sql !== '') {
        try {
            $stmt = $pdo->query($sql);          // если есть результат — получим PDOStatement [web:161]
            if ($stmt->columnCount() === 0) {   // нет набора строк
                $affected = $stmt->rowCount();
                $resultText = "Запрос выполнен, затронуто строк: " . (int)$affected;
            } else {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); [web:160][web:165]
                if ($rows) {
                    $headers = array_keys($rows[0]);
                    $resultText .= implode("\t", $headers) . "\n";
                    foreach ($rows as $row) {
                        $line = [];
                        foreach ($headers as $h) {
                            $line[] = (string)$row[$h];
                        }
                        $resultText .= implode("\t", $line) . "\n";
                    }
                } else {
                    $resultText = "Результат пуст.";
                }
            }
        } catch (PDOException $e) {
            $resultText = "Ошибка: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $resultText = "Введите SQL запрос.";
    }
}
?>
<form method="post">
    <label>SQL (любой):</label><br>
    <textarea name="sql" rows="4" cols="80"><?= isset($sql) ? htmlspecialchars($sql) : '' ?></textarea><br>
    <button type="submit">Выполнить</button>
</form>

<?php if ($resultText): ?>
    <pre><?= htmlspecialchars($resultText) ?></pre>
<?php endif; ?>
