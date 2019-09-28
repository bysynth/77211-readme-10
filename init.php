<?php
session_start();

date_default_timezone_set('Europe/Moscow');

require_once 'helpers.php';
require_once 'functions.php';
require_once 'vendor/autoload.php';

$db_connect = mysqli_connect('localhost', 'root', '', 'readme');
mysqli_set_charset($db_connect, 'utf8');

if (!$db_connect) {
    $connect_error = 'Ошибка №' . mysqli_connect_errno() . ' -- ' . mysqli_connect_error();
    exit($connect_error);
}

define('POST_TYPE_TEXT', '1');
define('POST_TYPE_QUOTE', '2');
define('POST_TYPE_PHOTO', '3');
define('POST_TYPE_VIDEO', '4');
define('POST_TYPE_LINK', '5');

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername('keks@phpdemo.ru');
$transport->setPassword('htmlacademy');
$mailer = new Swift_Mailer($transport);
