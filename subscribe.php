<?php

require_once 'init.php';

if (!isset($_SESSION['user']['id'], $_GET['subscribe_user_id']) || $_GET['subscribe_user_id'] === '') {
    header('Location: /index.php');
    exit();
}

$author_id = $_SESSION['user']['id'];
$subscribe_user_id = (int)$_GET['subscribe_user_id'];
$subscribe_user_info = get_user_info($db_connect, $subscribe_user_id);

if (!isset($subscribe_user_info['id']) || $subscribe_user_info['id'] !== $subscribe_user_id) {
    http_response_code(404);
    exit('Ошибка -- Что-то пошло не так');
}

$recipient = [$subscribe_user_info['email'] => $subscribe_user_info['name']];
$message_content = 'Здравствуйте, '. $subscribe_user_info['name'] . '. На вас подписался новый пользователь ' . $_SESSION['user']['name'] .
    '. Вот ссылка на его профиль: ' . 'http://readme/profile.php?user=' . $_SESSION['user']['id'];

$message = new Swift_Message();
$message->setSubject('У вас новый подписчик');
$message->setFrom(['keks@phpdemo.ru' => 'README']);
$message->setTo($recipient);
$message->setBody($message_content, 'text/plain');


if (is_subscribed($db_connect, $author_id, $subscribe_user_id) === false) {
    $sql = 'INSERT INTO subscriptions (author_id, subscribe_user_id) VALUES (?, ?)';
    db_insert_data($db_connect, $sql, [$author_id, $subscribe_user_id]);

    $mailer->send($message);

    header('Location: /profile.php?user=' . $subscribe_user_id);

} else {
    $sql = 'DELETE FROM subscriptions WHERE author_id = ? AND subscribe_user_id = ?';
    db_insert_data($db_connect, $sql, [$author_id, $subscribe_user_id]);

    header('Location: /profile.php?user=' . $subscribe_user_id);
}


