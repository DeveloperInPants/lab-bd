<?php
echo "<h2>client4: SELECT с таб-разделённым выводом</h2>";

$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $_POST['sql'] ?? '';

    if ($sql !== '') {
        try {
            $stmt = $pdo->query($sql);              // простой SELECT без параметров [web:161]
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  // [web:160][web:165]
            if ($rows) {
                $headers = array_keys($rows[0]);
                $output .= implode("\t", $headers) . "\n";
                foreach ($rows as $row) {
                    $line = [];
                    foreach ($headers as $h) {
                        $line[] = (string)$row[$h];
                    }
                    $output .= implode("\t", $line) . "\n";
                }
            } else {
                $output = "Нет строк в результате.";
            }
        } catch (PDOException $e) {
            $output = "Ошибка: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $output = "Введите SQL SELECT.";
    }
}
?>
<form method="post">
    <label>SQL (SELECT):</label><br>
    <textarea name="sql" rows="4" cols="80"><?= isset($sql) ? htmlspecialchars($sql) : '' ?></textarea><br>
    <button type="submit">Выполнить</button>
</form>

<?php if ($output): ?>
    <pre><?= htmlspecialchars($output) ?></pre>
<?php endif; ?>
