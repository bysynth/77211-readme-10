<?php
require_once 'init.php';

if (!isset($_SESSION['user']['id'], $_GET['post_id']) || $_GET['post_id'] === '') {
    header('Location: /index.php');
    exit();
}

$user_id = $_SESSION['user']['id'];
$post_id = (int)$_GET['post_id'];

if (is_post_exists($db_connect, $post_id)) {
    $sql = 'SELECT created_at, title, content, cite_author, is_repost, author_id, original_author_id, content_type 
            FROM posts WHERE id = ?';
    $post = db_fetch_data($db_connect, $sql, [$post_id], true);

    $post['created_at'] = date('Y-m-d H:i:s');
    $post['original_author_id'] = $post['author_id'];
    $post['author_id'] = $user_id;
    $post['is_repost'] = 1;

    $sql_insert = 'INSERT INTO posts
            (created_at, title, content, cite_author, is_repost, author_id, original_author_id, content_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    $post_id = mysqli_real_escape_string($db_connect, $post_id);
    $sql_update_repost_cnt = "UPDATE posts SET reposts_counter = reposts_counter + 1 WHERE id = $post_id";

    mysqli_query($db_connect, 'START TRANSACTION');

    $stmt = db_get_prepare_stmt($db_connect, $sql_insert, $post);

    $res1 = mysqli_stmt_execute($stmt);
    $res2 = mysqli_query($db_connect, $sql_update_repost_cnt);

    if ($res1 && $res2) {
        mysqli_query($db_connect, 'COMMIT');
    } else {
        mysqli_query($db_connect, 'ROLLBACK');
    }

    header('Location: /profile.php?user=' . $user_id);

} else {
    http_response_code(404);
    exit('Ошибка -- Что-то пошло не так');
}
