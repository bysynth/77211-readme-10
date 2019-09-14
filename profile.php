<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

if (!isset($_GET['user']) || $_GET['user'] === '') {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$user_id = $_GET['user'] ?? null;
$type = $_GET['type'] ?? null;

if (!isset($type) || ($type !== 'posts' && $type !== 'likes' && $type !== 'subscriptions')) {
    $url = 'Location: /profile.php?user=' . $user_id . '&type=posts';
    header($url);
}

$user_info = get_user_info($db_connect, $user_id);

if (!isset($user_info)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$user_publications_count = isset($user_id) ? get_publications_count($db_connect,
    $user_id) : 0;
$user_subscriptions_count = isset($user_id) ? get_subscriptions_count($db_connect,
    $user_id) : 0;

$urls = [
    'posts' => '/profile.php?user=' . $user_id . '&type=posts',
    'likes' => '/profile.php?user=' . $user_id . '&type=likes',
    'subscriptions' => '/profile.php?user=' . $user_id . '&type=subscriptions'
];

$template_data = [
    'urls' => $urls,
    'user_info' => $user_info,
    'user_publications_count' => $user_publications_count,
    'user_subscriptions_count' => $user_subscriptions_count
];

if ($type === 'posts') {
    $template_data['posts'] = get_profile_posts($db_connect, $user_id);
    $page_content = include_template('profile-post.php', $template_data);
}

if ($type === 'likes') {
    $page_content = include_template('profile-likes.php', $template_data);
}

if ($type === 'subscriptions') {
    $page_content = include_template('profile-subscriptions.php', $template_data);
}

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--profile',
        'title' => 'readme: профиль'
    ]);

print($layout_content);
