<?php
echo "<h2>client6: форматированная таблица</h2>";

$tableHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $_POST['sql'] ?? '';

    if ($sql !== '') {
        try {
            $stmt = $pdo->query($sql);        // [web:161]
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); [web:160]
            if ($rows) {
                $headers = array_keys($rows[0]);
                ob_start();
                echo '<table>';
                echo '<thead><tr>';
                foreach ($headers as $h) {
                    echo '<th>' . htmlspecialchars($h) . '</th>';
                }
                echo '</tr></thead><tbody>';
                foreach ($rows as $row) {
                    echo '<tr>';
                    foreach ($headers as $h) {
                        echo '<td>' . htmlspecialchars((string)$row[$h]) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody></table>';
                $tableHtml = ob_get_clean();
            } else {
                $tableHtml = "<p>Результат пуст.</p>";
            }
        } catch (PDOException $e) {
            $tableHtml = "<p>Ошибка: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $tableHtml = "<p>Введите SQL SELECT.</p>";
    }
}
?>
<form method="post">
    <label>SQL (SELECT):</label><br>
    <textarea name="sql" rows="4" cols="80"><?= isset($sql) ? htmlspecialchars($sql) : '' ?></textarea><br>
    <button type="submit">Выполнить</button>
</form>

<?= $tableHtml ?>
