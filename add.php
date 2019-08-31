<?php

require_once 'init.php';

$content_types = get_content_types($db_connect);

if (!empty($_GET)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (array_key_exists('text-submit', $_POST)) {
        $post = [
            'title' => $_POST['text-heading'] ?? null,
            'content' => $_POST['text-content'] ?? null,
            'tags' => $_POST['text-tags'] ?? null
        ];
    }

    $required = ['title', 'content'];
    $errors = [];

    $rules = [
        'title' => function () use ($post) {
            return validate_filled($post['title'], 'Заголовок');
        },
        'content' => function () use ($post) {
            return validate_filled($post['content'], 'Текст поста');
        }
    ];

    foreach ($post as $key => $value) {
        if (!isset($errors[$key]) && isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {
        $page_content = include_template('add-post.php',
            [
                'content_types' => $content_types,
                'errors' => $errors
            ]);
    } else {
        $sql_post = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, 1, 1)';
        $post_id = db_insert_data($db_connect, $sql_post, [$post['title'], $post['content']]);

        if ($post['tags'] !== '') {
            db_insert_uniq_hashtags($db_connect, $post['tags']);
            db_insert_hashtag_posts_connection($db_connect, $post['tags'], $post_id);
        }

        header('Location: post.php?id=' . $post_id);
        exit();
    }

} else {
    $page_content = include_template('add-post.php',
        [
            'content_types' => $content_types,
            'errors' => null
        ]);
}

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--adding-post',
        'title' => 'readme: добавление публикации',
        'user_name' => $user_name
    ]);

print($layout_content);
