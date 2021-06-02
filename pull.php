<?php

include 'functions.php';
$pdo = pdo_connect();

if (isset($_GET['id']) && isset($_GET['amount'])) {
    $pdo->query("BEGIN");
    $data_pulled = $_GET['amount'];
    $stmt = $pdo->prepare('SELECT * FROM deposit WHERE id = ? FOR UPDATE');
    $stmt->execute([$_GET['id']]);
    $deposit = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($deposit['amount'] >= $data_pulled) {
        $d_now = $deposit['amount'] - $data_pulled;
        $stmt = $pdo->prepare('UPDATE deposit set amount= ? WHERE id = ?');
        $stmt->execute([$d_now, $_GET['id']]);
        echo "success\n";
    } else {
        die('Not enough amount');
    }
    $pdo->query("COMMIT");
} else {
    die('No ID specified!');
}
