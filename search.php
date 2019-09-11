<?php
require_once 'init.php';

if (!isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit();
}

$search_query = $_GET['q'] ?? '';
$search_query = trim(clear_input($search_query));

if ($search_query !== '' && strpos($search_query, '#') === 0) {
    $posts = get_posts($db_connect, null, null, $search_query, false, false, false, true);
} else {
    $posts = get_posts($db_connect, null, null, $search_query, false, false, true);
}

if (empty($posts)) {
    $page_content = include_template('search-no-results.php',
        [
            'search_query' => $search_query
        ]);
} else {
    $page_content = include_template('search-results.php',
        [
            'posts' => $posts,
            'search_query' => $search_query
        ]);
}



$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'main_class' => 'page__main--search-results',
        'title' => 'readme: страница результатов поиска'
    ]);

print($layout_content);
