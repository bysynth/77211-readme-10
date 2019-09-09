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
        'password' => $_POST['password'] ?? null
    ];

    $rules = [
        'email' => function () use ($form, $db_connect) {
            return validate_login_email($db_connect, $form['email'], 'Электронная почта');
        },
        'password' => function () use ($form, $db_connect) {
            return validate_login_password($db_connect, $form['email'], $form['password'], 'Пароль');
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
        $email = mysqli_real_escape_string($db_connect, $form['email']);
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $user_data = mysqli_fetch_assoc(get_mysqli_result($db_connect, $sql));

        $_SESSION['user'] = $user_data;

        header('Location: /feed.php');
        exit();
    }
}

$page_content = include_template('login.php',
    [
        'errors' => $errors
    ]);

$layout_content = include_template('layout-reg.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--login',
        'title' => 'readme: авторизация',
        'is_login_active' => true,
        'reg_url' => '/registration.php'
    ]);

print($layout_content);
