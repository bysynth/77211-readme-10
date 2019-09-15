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

$author_id = $_GET['user'] ?? null;
$type = $_GET['type'] ?? null;

if (!isset($type) || ($type !== 'posts' && $type !== 'likes' && $type !== 'subscriptions')) {
    $url = 'Location: /profile.php?user=' . $author_id . '&type=posts';
    header($url);
}

$user_info = get_user_info($db_connect, $author_id);

if (!isset($user_info)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

$user_publications_count = isset($author_id) ? get_publications_count($db_connect,
    $author_id) : 0;
$user_subscriptions_count = isset($author_id) ? get_subscriptions_count($db_connect,
    $author_id) : 0;

$urls = [
    'posts' => '/profile.php?user=' . $author_id . '&type=posts',
    'likes' => '/profile.php?user=' . $author_id . '&type=likes',
    'subscriptions' => '/profile.php?user=' . $author_id . '&type=subscriptions'
];

$template_data = [
    'urls' => $urls,
    'user_info' => $user_info,
    'user_publications_count' => $user_publications_count,
    'user_subscriptions_count' => $user_subscriptions_count,
    'is_subscribed' => check_subscrtiption($db_connect, $_SESSION['user']['id'], $author_id)
];

if ($type === 'posts') {
    $template_data['template'] = 'profile-posts.php';
    $template_data['content'] = get_profile_posts($db_connect, $author_id);
    $template_data['is_posts'] = true;
    $page_content = include_template('profile.php', $template_data);
}

if ($type === 'likes') {
    $template_data['template'] = 'profile-likes.php';
//    $template_data['content'] = 'likes';
    $template_data['is_likes'] = true;
    $page_content = include_template('profile.php', $template_data);
}

if ($type === 'subscriptions') {
    $template_data['template'] = 'profile-subscriptions.php';
//    $template_data['content'] = 'sub';
    $template_data['is_subscriptions'] = true;
    $page_content = include_template('profile.php', $template_data);
}

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--profile',
        'title' => 'readme: профиль'
    ]);

print($layout_content);
