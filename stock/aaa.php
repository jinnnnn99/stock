<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    $amount = (int)$_POST["amount"];
    $description = $_POST["description"];

    try {
        $stmt = $pdo->prepare("INSERT INTO transactions (type, amount, description) VALUES (:type, :amount, :description)");
        $stmt->execute(['type' => $type, 'amount' => $amount, 'description' => $description]);

        // 세션에 잔액 저장
        if (!isset($_SESSION["balance"])) {
            $_SESSION["balance"] = 0;
        }
        $_SESSION["balance"] += ($type === 'minus' ? -$amount : $amount);

        // 세션에 이력 추가
        if (!isset($_SESSION["history"])) {
            $_SESSION["history"] = [];
        }
        $_SESSION["history"][] = [
            'created_at' => date('Y-m-d H:i:s'),
            'type' => $type,
            'amount' => $amount,
            'description' => $description
        ];

        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}
?>
