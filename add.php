<?php

require_once 'init.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: /index.php');
    exit();
}

$author_id = $_SESSION['user']['id'];
$type = $_GET['type'] ?? null;

$content_types = get_content_types($db_connect);
$errors = [];

$subscribers_list = get_subscribers_list($db_connect, $author_id);

if (!isset($type) || is_type_exist($content_types, $type) === false) {
    $url = 'Location: /add.php?type=1';
    header($url);
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST)) {
        exit('Что-то пошло не так!');
    }

    if (array_key_exists('text', $_POST)) {
        $post_type = 'text';
        $post = [
            'text-heading' => $_POST['text-heading'] ?? null,
            'text-content' => $_POST['text-content'] ?? null,
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
            'quote-heading' => $_POST['quote-heading'] ?? null,
            'quote-content' => $_POST['quote-content'] ?? null,
            'quote-author' => $_POST['quote-author'] ?? null,
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
            'photo-heading' => $_POST['photo-heading'] ?? null,
            'photo-url' => $_POST['photo-url'] ?? null,
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

    if (array_key_exists('video', $_POST)) {
        $post_type = 'video';
        $post = [
            'video-heading' => $_POST['video-heading'] ?? null,
            'video-url' => $_POST['video-url'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];

        $rules = [
            'video-heading' => function () use ($post) {
                return validate_filled($post['video-heading'], 'Заголовок');
            },
            'video-url' => function () use ($post) {
                return validate_video_url($post['video-url'], 'Ссылка Youtube');
            }
        ];
    }

    if (array_key_exists('link', $_POST)) {
        $post_type = 'link';
        $post = [
            'link-heading' => $_POST['link-heading'] ?? null,
            'link-url' => $_POST['link-url'] ?? null,
            'tags' => $_POST['tags'] ?? null
        ];

        $rules = [
            'link-heading' => function () use ($post) {
                return validate_filled($post['link-heading'], 'Заголовок');
            },
            'link-url' => function () use ($post) {
                return validate_link($post['link-url'], 'Ссылка');
            }
        ];
    }

    foreach ($post as $key => $value) {
        if (!isset($errors[$key]) && isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);

    if (count($errors) === 0) {

        if ($post_type === 'text') {
            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, ?, 1)';
            $post_name = $post['text-heading'];
            $data = [
                $post_name,
                $post['text-content'],
                $author_id
            ];
        }

        if ($post_type === 'quote') {
            $sql = 'INSERT INTO posts (title, content, cite_author, author_id, content_type) VALUES (?, ?, ?, ?, 2)';
            $post_name = $post['quote-heading'];
            $data = [
                $post_name,
                $post['quote-content'],
                $post['quote-author'],
                $author_id
            ];
        }

        if ($post_type === 'photo') {

            if ($post['file']['error'] !== UPLOAD_ERR_NO_FILE) {
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

            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, ?, 3)';
            $post_name = $post['photo-heading'];
            $data = [
                $post_name,
                $post['path'],
                $author_id
            ];
        }

        if ($post_type === 'video') {
            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, ?, 4)';
            $post_name = $post['video-heading'];
            $data = [
                $post_name,
                $post['video-url'],
                $author_id
            ];
        }

        if ($post_type === 'link') {
            $sql = 'INSERT INTO posts (title, content, author_id, content_type) VALUES (?, ?, ?, 5)';
            $post_name = $post['link-heading'];
            $data = [
                $post_name,
                $post['link-url'],
                $author_id
            ];
        }

        $post_id = db_insert_data($db_connect, $sql, $data);

        if ($post['tags'] !== '') {
            db_insert_uniq_hashtags($db_connect, $post['tags']);
            db_insert_hashtag_posts_connection($db_connect, $post['tags'], $post_id);
        }

        $message = new Swift_Message();
        $message->setFrom(['keks@phpdemo.ru' => 'README']);
        $message_subject = 'Новая публикация от пользователя ' . $_SESSION['user']['name'];
        $message->setSubject($message_subject);

        foreach ($subscribers_list as $subscriber){
            $message_content = '«Здравствуйте, ' . $subscriber['name'] . '. Пользователь ' . $_SESSION['user']['name'] .
            ' только что опубликовал новую запись «' . $post_name .'». Посмотрите её на странице пользователя: ' .
            'http://readme/profile.php?user=' . $_SESSION['user']['id'];
            $message->setBody($message_content, 'text/plain');
            $message->setTo([$subscriber['email'] => $subscriber['name']]);
            $mailer->send($message);
        }

        header('Location: post.php?id=' . $post_id);
        exit();
    }
}

$page_content = include_template('add-post.php',
    [
        'type' => $type,
        'content_types' => $content_types,
        'errors' => $errors
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--adding-post',
        'title' => 'readme: добавление публикации',
        'user_name' => $user_name
    ]);

print($layout_content);
