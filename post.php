<?php
require_once 'init.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: /index.php');
    exit();
}

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$session_user_id = (int)$_SESSION['user']['id'];
$id = (int)$_GET['id'];
$post = get_post($db_connect, $id);

if (empty($post)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$user_subscriptions_count = isset($post['author_id']) ? get_subscriptions_count($db_connect,
    $post['author_id']) : 0;
$user_publications_count = isset($post['author_id']) ? get_publications_count($db_connect,
    $post['author_id']) : 0;

change_post_views_count($db_connect, $id);

$error = [];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['comment'], $_POST['post-id'])) {
        $comment_input = trim($_POST['comment']);
        $post_id = (int)$_POST['post-id'];
    }
    $error = validate_comment($db_connect, $comment_input, $post_id);

    if (empty($error)) {
        $sql = 'INSERT INTO comments (comment, author_id, post_id) VALUES (?, ?, ?)';
        $result = db_insert_data($db_connect, $sql, [$comment_input, $_SESSION['user']['id'], $id]);
        $url = 'Location: /profile.php?user=' . $post['author_id'] . '&type=posts';
        header($url);
    }
}

$page_content = include_template('post.php',
    [
        'post' => $post,
        'comments' => get_comments($db_connect, $id),
        'user_subscriptions_count' => $user_subscriptions_count,
        'user_publications_count' => $user_publications_count,
        'session_user_id' => $session_user_id,
        'is_subscribed' => is_subscribed($db_connect, $_SESSION['user']['id'], $post['author_id']),
        'error' => $error
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--publication',
        'title' => 'readme: ' . $post['title']
    ]);

print($layout_content);
