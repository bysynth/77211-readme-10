<?php
date_default_timezone_set('Europe/Moscow');

$db_connect = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($db_connect, 'utf8');

if (!$db_connect) {
    $connect_error = 'Ошибка №' . mysqli_connect_errno() . ' -- ' . mysqli_connect_error();
    exit($connect_error);
}