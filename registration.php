<?php
require_once 'init.php';

if (isset($_SESSION['user'])) {
    header('Location: /feed.php');
    exit();
}

$errors = [];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST)) {
        exit('Что-то пошло не так!');
    }

    $form = [
        'email' => $_POST['email'] ?? null,
        'login' => $_POST['login'] ?? null,
        'password' => $_POST['password'] ?? null,
        'password-repeat' => $_POST['password-repeat'] ?? null,
        'userpic-file' => $_FILES['userpic-file'] ?? null
    ];

    $rules = [
        'email' => function () use ($form, $db_connect) {
            return validate_email($db_connect, $form['email'], 'Электронная почта');
        },
        'login' => function () use ($form, $db_connect) {
            return validate_login($db_connect, $form['login'], 'Логин');
        },
        'password' => function () use ($form) {
            return validate_filled($form['password'], 'Пароль');
        },
        'password-repeat' => function () use ($form) {
            return validate_password_repeat($form['password'], $form['password-repeat'], 'Повтор пароля');
        },
        'userpic-file' => function () use ($form) {
            return validate_avatar($form['userpic-file'], 'Аватарка');
        }
    ];

    foreach ($form as $key => $value) {
        if (!isset($errors[$key]) && isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }

    $errors = array_filter($errors);

    if (count($errors) === 0) {

        $password = password_hash($form['password'], PASSWORD_DEFAULT);

        if ($form['userpic-file']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (isset($_FILES['userpic-file']['name'])) {
                $temp_name = $_FILES['userpic-file']['tmp_name'];
                $file_ext = pathinfo($_FILES['userpic-file']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('', false) . '.' . $file_ext;
                $uploaddir = __DIR__ . '/uploads/';
                $file_url = $uploaddir . $filename;
                move_uploaded_file($temp_name, $file_url);
                $form['path'] = $filename;
            }

            $sql = 'INSERT INTO users (email, name, password, avatar) VALUES (?, ?, ?, ?)';
            $data = [
                $form['email'],
                $form['login'],
                $password,
                $form['path']
            ];
        } else {
            $sql = 'INSERT INTO users (email, name, password) VALUES (?, ?, ?)';
            $data = [
                $form['email'],
                $form['login'],
                $password,
            ];
        }

        $stmt = db_get_prepare_stmt($db_connect, $sql, $data);
        $result = mysqli_stmt_execute($stmt);

        if ($result !== false) {
            header("Location: /login.php");
            exit();
        }
    }
}

$page_content = include_template('registration.php',
    [
        'errors' => $errors
    ]);

$layout_content = include_template('layout-reg.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--registration',
        'title' => 'readme: регистрация',
        'is_reg_active' => true,
        'login_url' => '/login.php'
    ]);

print($layout_content);
