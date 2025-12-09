<?php
echo "<h2>client7: подготовленный SELECT</h2>";

$resultHtml = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $minId = $_POST['min_id'] ?? '';

    if ($minId !== '' && ctype_digit($minId)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM some_table WHERE id >= :min_id"); [web:141][web:155]
            $stmt->execute(['min_id' => (int)$minId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); [web:160][web:165]

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
                $resultHtml = ob_get_clean();
            } else {
                $resultHtml = "<p>Результат пуст.</p>";
            }
        } catch (PDOException $e) {
            $resultHtml = "<p>Ошибка: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        $resultHtml = "<p>Введите корректное целое значение min_id.</p>";
    }
}
?>
<form method="post">
    <label>Минимальный id (min_id):</label><br>
    <input type="text" name="min_id" value="<?= isset($minId) ? htmlspecialchars($minId) : '' ?>">
    <button type="submit">Выполнить SELECT</button>
</form>

<?= $resultHtml ?>
