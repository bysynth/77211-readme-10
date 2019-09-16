<?php

require_once 'init.php';

if (!isset($_SESSION['user'], $_GET['subscribe_user_id']) || $_GET['subscribe_user_id'] === '') {
    header('Location: /index.php');
    exit();
}

$author_id = $_SESSION['user']['id'];
$subscribe_user_id = (int)$_GET['subscribe_user_id'];
$subscribe_user_info = get_user_info($db_connect, $subscribe_user_id);

if ($subscribe_user_info['id'] !== $subscribe_user_id) {
    http_response_code(404);
    exit('Ошибка -- Что-то пошло не так');
}

if (!check_subscription($db_connect, $author_id, $subscribe_user_id)) {
    $sql = 'INSERT INTO subscriptions (author_id, subscribe_user_id) VALUES (?, ?)';
    $subscription_id = db_insert_data($db_connect, $sql, [$author_id, $subscribe_user_id]);

    if ($subscription_id) {
        header('Location: /profile.php?user=' . $subscribe_user_id);
    }
} else {
    $subscription_id = check_subscription($db_connect, $author_id, $subscribe_user_id);
    $sql = 'DELETE FROM subscriptions WHERE id = ' . $subscription_id['id'];
    $result = get_mysqli_result($db_connect, $sql);

    if ($result) {
        header('Location: /profile.php?user=' . $subscribe_user_id);
    }
}


