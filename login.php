<?php

require_once 'init.php';

if (isset($_SESSION['user'])) {
    header('Location: /feed.php');
    exit();
}

$errors = login($db_connect);

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
