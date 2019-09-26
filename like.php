<?php
require_once 'init.php';

if (!isset($_SESSION['user']['id'], $_GET['post_id']) || $_GET['post_id'] === '') {
    header('Location: /index.php');
    exit();
}

$user_id = $_SESSION['user']['id'];
$post_id = (int)$_GET['post_id'];

$referer_link = $_SERVER['HTTP_REFERER'] ?? '/popular.php';

if (is_post_exists($db_connect, $post_id)) {
    if (!is_like_exists($db_connect, $user_id, $post_id)) {
        $sql = 'INSERT INTO likes (user_id, post_id) VALUES (?, ?)';
        $like_id = db_insert_data($db_connect, $sql, [$user_id, $post_id]);
        header('Location:' . $referer_link);
    } else {
        header('Location:' . $referer_link);
    }
} else {
    http_response_code(404);
    exit('Ошибка -- Что-то пошло не так');
}
