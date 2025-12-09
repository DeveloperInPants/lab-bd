<?php
echo "<h2>client3: запрос без результата</h2>";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = $_POST['sql'] ?? '';

    if ($sql !== '') {
        try {
            $affected = $pdo->exec($sql);            // INSERT/UPDATE/DELETE [web:159]
            $message = "Запрос выполнен, затронуто строк: " . (int)$affected;
        } catch (PDOException $e) {
            $message = "Ошибка: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $message = "Введите SQL запрос.";
    }
}
?>
<form method="post">
    <label>SQL (INSERT/UPDATE/DELETE):</label><br>
    <textarea name="sql" rows="4" cols="80"><?= isset($sql) ? htmlspecialchars($sql) : '' ?></textarea><br>
    <button type="submit">Выполнить</button>
</form>

<?php if ($message): ?>
    <p><strong><?= $message ?></strong></p>
<?php endif; ?>
