<?php
require_once 'init.php';

if (isset($_SESSION['user'])) {
    header('Location: /feed.php');
    exit();
}

$errors = login($db_connect);

$layout_content = include_template('layout-ext.php',
    [
        'errors' => $errors
    ]);

print($layout_content);
