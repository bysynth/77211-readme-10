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

    $errors = [];

    if (array_key_exists('text', $_POST)) {
        $post_type = 'text';
        $post = [
            'text-heading' => $_POST['title'] ?? null,
            'text-content' => $_POST['content'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];

        $rules = [
            'text-heading' => function () use ($post) {
                return validate_filled($post['text-heading'], 'Заголовок');
            },
            'text-content' => function () use ($post) {
                return validate_filled($post['text-content'], 'Текст поста');
            }
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

        $rules = [
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
    }

    if (array_key_exists('photo', $_POST)) {

        $post_type = 'photo';
        $post = [
            'photo-heading' => $_POST['title'] ?? null,
            'photo-url' => $_POST['content'] ?? null,
            'tags' => $_POST['tags'] ?? null,
            'file' => $_FILES['upload-file'] ?? null
        ];

        $rules = [
            'photo-heading' => function () use ($post) {
                return validate_filled($post['photo-heading'], 'Заголовок');
            },
            'photo-url' => function () use ($post) {
                return validate_photo_url($post['photo-url'], 'Ссылка из интернета');
            },
            'file' => function () use ($post) {
                        return validate_uploaded_file($post['file'], 'Загруженный файл');
            }
        ];
    }

    foreach ($post as $key => $value) {
        if (!isset($errors[$key]) && isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    if (empty($post['photo-url']) && $post['file']['error'] === 4) {
        $errors[] = [
            'input_name' => 'Картинка',
            'input_error_desc' => 'Укажите ссылку на файл или выберите файл для загрузки'
        ];
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

            if ($post['file']['error'] !== 4) {
                if (isset($_FILES['upload-file']['name'])) {
                    $temp_name = $_FILES['upload-file']['tmp_name'];
                    $file_ext = pathinfo($_FILES['upload-file']['name'], PATHINFO_EXTENSION);
                    $filename = uniqid('', false) . '.' . $file_ext;
                    $uploaddir = __DIR__ . '/uploads/';
                    $file_url = $uploaddir . $filename;
                    move_uploaded_file($temp_name, $file_url);
                    $post['path'] = $filename;
                }
            } elseif (isset($post['photo-url'])) {
                $url = $post['photo-url'];
                $file_ext = get_link_file_ext($url);
                $file_input = file_get_contents($url);
                $filename = uniqid('', false) . '.' . $file_ext;
                $uploaddir = __DIR__ . '/uploads/';
                $file_url = $uploaddir . $filename;
                file_put_contents($file_url, $file_input);
                $post['path'] = $filename;
            }

            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, 3, 3)';
            $data = [
                $post['photo-heading'],
                $post['path']
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
