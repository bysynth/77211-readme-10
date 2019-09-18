<?php
require_once 'init.php';

if (!isset($_SESSION['user']['id'])) {
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

$urls = [
    'posts' => '/profile.php?user=' . $author_id . '&type=posts',
    'likes' => '/profile.php?user=' . $author_id . '&type=likes',
    'subscriptions' => '/profile.php?user=' . $author_id . '&type=subscriptions'
];

$template_data = [
    'urls' => $urls,
    'user_info' => $user_info,
    'user_publications_count' => get_publications_count($db_connect, $author_id),
    'user_subscriptions_count' => get_subscriptions_count($db_connect, $author_id),
    'is_subscribed' => is_subscribed($db_connect, $_SESSION['user']['id'], $author_id)
];

$page_content = '';

if ($type === 'posts') {
    $template_data['template'] = 'profile-posts.php';
    $template_data['content'] = get_profile_posts($db_connect, $author_id);
    $template_data['is_posts'] = true;
    $page_content = include_template('profile.php', $template_data);
}

if ($type === 'likes') {
    $template_data['template'] = 'profile-likes.php';
    $template_data['content'] = get_profile_likes_list($db_connect, $author_id);
    $template_data['is_likes'] = true;
    $page_content = include_template('profile.php', $template_data);
}

if ($type === 'subscriptions') {
    $raw_user_subscription_list = get_user_subscriptions($db_connect, $author_id);
    $user_subscriptions_list = [];
    foreach ($raw_user_subscription_list as $sub) {
        if (is_subscribed($db_connect, $_SESSION['user']['id'], $sub['user_id'])) {
            $sub['is_session_user_subscribed'] = true;
        } else {
            $sub['is_session_user_subscribed'] = false;
        }
        $user_subscriptions_list[] = $sub;
    }

    $template_data['template'] = 'profile-subscriptions.php';
    $template_data['content'] = $user_subscriptions_list;
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
