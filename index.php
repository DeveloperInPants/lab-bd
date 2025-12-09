<?php
require 'db.php';

$page = $_GET['page'] ?? 'client1';   // по умолчанию client1
$allowed = ['client1','client2','client3','client4','client5','client6','client7'];
if (!in_array($page, $allowed, true)) {
    $page = 'client1';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>DB Clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Лабораторные клиент1–клиент7</h1>
    <nav>
        <?php foreach ($allowed as $p): ?>
            <a href="?page=<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></a>
        <?php endforeach; ?>
    </nav>
</header>

<main>
    <?php include $page . '.php'; ?>
</main>
</body>
</html>
