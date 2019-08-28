<?php
require_once 'init.php';
require_once 'helpers.php';
require_once 'functions.php';
require_once 'data.php';

if (empty($_GET)) {
    http_response_code(404);
    exit;
}

$id = $_GET['id'];

$post_content = get_post($db_connect, $id);

if (empty($post_content)) {
    http_response_code(404);
    die;
}

$user_subscriptions_count = get_subsriptions_count($db_connect, $post_content['author_id']);
$user_publications_count = get_publications_count($db_connect, $post_content['author_id']);

$page_content = include_template('post.php',
    [
        'post_content' => $post_content,
        'user_subscriptions_count' => $user_subscriptions_count,
        'user_publications_count' => $user_publications_count
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--publication',
        'title' => 'readme: ' . $post_content['title'],
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

print($layout_content);
