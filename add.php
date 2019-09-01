<?php

require_once 'init.php';

$content_types = get_content_types($db_connect);

if (!empty($_GET)) {
    http_response_code(404);
    exit('Ошибка 404 -- Запрашиваемая страница не найдена');
}

//var_dump($_POST);

// TODO: для каждой формы одинаковые name - при сборе $post - назначить уникальные

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (array_key_exists('text', $_POST)) {
        $post_type = 'text';
        $post = [
            'text-heading' => $_POST['title'] ?? null,
            'text-content' => $_POST['content'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];
    }

    if (array_key_exists('quote', $_POST)) {
        $post_type = 'quote';
        $post = [
            'quote-heading' => $_POST['title'] ?? null,
            'quote-content' => $_POST['content'] ?? null,
            'quote-author' => $_POST['author'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];
    }

    if (array_key_exists('photo', $_POST)) {
        $post_type = 'photo';
        $post = [
            'photo-heading' => $_POST['title'] ?? null,
            'photo-content' => $_POST['content'] ?? null,
            'quote-author' => $_POST['author'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];
    }

    $errors = [];

    $rules = [
        'text-heading' => function () use ($post) {
            return validate_filled($post['text-heading'], 'Заголовок');
        },
        'text-content' => function () use ($post) {
            return validate_filled($post['text-content'], 'Текст поста');
        },
        'quote-heading' => function () use ($post) {
            return validate_filled($post['quote-heading'], 'Заголовок');
        },
        'quote-content' => function () use ($post) {
            return validate_filled($post['quote-content'], 'Текст цитаты');
        },
        'quote-author' => function () use ($post) {
            return validate_filled($post['quote-author'], 'Автор цитаты');
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

        if ($post_type === 'text') {
            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, 1, 1)';
            $data = [
                $post['text-heading'],
                $post['text-content']
            ];
        }

        if ($post_type === 'quote') {
            $sql = 'INSERT INTO posts (title, content, cite_author, author_id, content_type) VALUES (?, ?, ?, 2, 2)';
            $data = [
                $post['quote-heading'],
                $post['quote-content'],
                $post['quote-author']
            ];
        }

        if ($post_type === 'photo') {
            $sql = 'INSERT INTO posts (title, content, cite_author, author_id, content_type) VALUES (?, ?, ?, 2, 2)';
            $data = [
                $post['quote-heading'],
                $post['quote-content'],
                $post['quote-author']
            ];
        }

        $post_id = db_insert_data($db_connect, $sql, $data);

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
