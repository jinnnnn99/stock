<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>家計簿</title>
</head>
<body>
    <h1>家計簿</h1>
    <form action="aaa.php" method="post">
        <label for="type">収入/支出:</label>
        <select name="type" id="type">
            <option value="plus">収入</option>
            <option value="minus">支出</option>
        </select><br><br>
        
        <label for="amount">金額:</label>
        <input type="number" name="amount" id="amount" required><br><br>
        
        <label for="description">用途:</label>
        <input type="text" name="description" id="description" required><br><br>
        
        <input type="submit" value="追加">
    </form>

    <h2>残高</h2>
    <p id="balance">¥<?php 
        session_start();
        echo isset($_SESSION["balance"]) ? number_format($_SESSION["balance"]) : 0; 
    ?></p>

    <h2>履歴</h2>
    <ul id="history">
        <?php
        if (isset($_SESSION["history"])) {
            foreach ($_SESSION["history"] as $entry) {
                $type = $entry['type'] === 'plus' ? '収入' : '支出';
                $amount = number_format($entry['amount']);
                echo "<li>{$entry['created_at']} - {$type} - ¥{$amount} - {$entry['description']}</li>";
            }
        }
        ?>
    </ul>
</body>
</html>
