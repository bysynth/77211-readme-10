<?php

//function db_fetch_data($link, $sql, $data = [])
//{
//    $result = [];
//    $stmt = db_get_prepare_stmt($link, $sql, $data);
//    mysqli_stmt_execute($stmt);
//    $res = mysqli_stmt_get_result($stmt);
//    if ($res) {
//        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
//    }
//    return $result;
//}
//
//function db_insert_data($link, $sql, $data = [])
//{
//    $stmt = db_get_prepare_stmt($link, $sql, $data);
//    $result = mysqli_stmt_execute($stmt);
//    if ($result) {
//        $result = mysqli_insert_id($link);
//    }
//    return $result;
//}

function cut_text($text, $length = 300)
{
    if (mb_strlen($text) > $length) {
        $text_array = explode(' ', $text);
        $length_sum = 0;
        $result_array = [];
        foreach ($text_array as $word) {
            $length_sum += mb_strlen($word) + 1;
            if ($length_sum < $length) {
                $result_array[] = $word;
            }
        }
        return '<p>' . implode(' ', $result_array) . '...' .
            '</p><a class="post-text__more-link" href="#">Читать далее</a>';
    }
    return '<p>' . $text . '</p>';
}

function clear_input($input)
{
    return htmlspecialchars($input);
}

function get_relative_time_format($time_data, $word)
{
    $dt_past = date_create($time_data);
    $dt_now = date_create('now');
    $dt_diff = date_diff($dt_now, $dt_past);
    $diff_minutes_count = (int)date_interval_format($dt_diff, '%i');
    $diff_hours_count = (int)date_interval_format($dt_diff, '%h');
    $diff_days_count = (int)date_interval_format($dt_diff, '%a');
    $diff_month_count = (int)date_interval_format($dt_diff, '%m');

    if ($diff_month_count > 0) {
        return $diff_month_count . ' ' . get_noun_plural_form($diff_month_count, 'месяц',
                'месяца', 'месяцев') . ' ' . $word;
    }

    if ($diff_days_count >= 7) {
        return round($diff_days_count / 7) . ' ' . get_noun_plural_form(round($diff_days_count / 7),
                'неделя', 'недели', 'недель') . ' ' . $word;
    }

    if ($diff_days_count > 0) {
        return $diff_days_count . ' ' . get_noun_plural_form($diff_days_count, 'день', 'дня',
                'дней') . ' ' . $word;
    }

    if ($diff_hours_count > 0) {
        return $diff_hours_count . ' ' . get_noun_plural_form($diff_hours_count, 'час', 'часа',
                'часов') . ' ' . $word;
    }

    return $diff_minutes_count . ' ' . get_noun_plural_form($diff_minutes_count, 'минута', 'минуты',
            'минут') . ' ' . $word;
}

function get_custom_time_format($time_data)
{
    $date_and_time = date_create($time_data);
    return date_format($date_and_time, 'd.m.Y H:i');
}

function get_content_types($db_connect)
{
    $sql = 'SELECT id, type_name, type_icon FROM content_types';

    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function is_type_exist ($arrays, $type) {
    $result = false;
    foreach ($arrays as $array) {
        if (in_array($type, $array, true)) {
            $result = true;
        }
    }
    return $result;
}

function get_posts($db_connect, $type)
{
    $sql = 'SELECT p.id, p.created_at, p.title, p.content, p.cite_author, ct.type_name, ct.type_icon, u.name, u.avatar 
            FROM posts AS p 
            JOIN content_types AS ct 
                ON ct.id = p.content_type 
            JOIN users as u 
                ON u.id = p.author_id ';
            if (isset($type)) {
                $sql .= 'WHERE p.content_type = ' . $type . ' ';
            }
            $sql .= 'ORDER BY p.views_counter DESC LIMIT 6;';

    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_post($db_connect, $id) {
    $sql = 'SELECT p.id, p.created_at, p.title, p.content, p.cite_author, p.views_counter, p.is_repost, p.content_type, 
            p.author_id, u.name, u.avatar, u.created_at as user_created_at
            FROM posts as p
            JOIN users as u
                ON u.id = p.author_id ';
    $sql .= 'WHERE p.id = ' . $id;

    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }
    return mysqli_fetch_assoc($result);
}

function get_publications_count($db_connect, $user_id) {
    $sql = 'SELECT id as count
            FROM posts
            WHERE author_id =' . $user_id;

    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }

    return mysqli_num_rows($result);
}

function get_subsriptions_count($db_connect, $user_id) {
    $sql = 'SELECT id
            FROM subscriptions
            WHERE author_id =' . $user_id;

    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }

    return mysqli_num_rows($result);
}
