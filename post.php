<?php

require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

if (!isset($_GET['id']) || $_GET['id'] === '') {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

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

$page_content = include_template('post.php',
    [
        'post' => $post,
        'comments' => get_comments($db_connect, $id),
        'user_subscriptions_count' => $user_subscriptions_count,
        'user_publications_count' => $user_publications_count,
        'is_subscribed' => check_subscription($db_connect, $_SESSION['user']['id'], $post['author_id'])
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--publication',
        'title' => 'readme: ' . $post['title']
    ]);

print($layout_content);
