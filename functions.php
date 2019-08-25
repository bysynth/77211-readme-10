<?php

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

function get_relative_time_format($time_data)
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
                'месяца', 'месяцев') . ' назад';
    }

    if ($diff_days_count >= 7) {
        return round($diff_days_count / 7) . ' ' . get_noun_plural_form(round($diff_days_count / 7),
                'неделя', 'недели', 'недель') . ' назад';
    }

    if ($diff_days_count > 0) {
        return $diff_days_count . ' ' . get_noun_plural_form($diff_days_count, 'день', 'дня',
                'дней') . ' назад';
    }

    if ($diff_hours_count > 0) {
        return $diff_hours_count . ' ' . get_noun_plural_form($diff_hours_count, 'час', 'часа',
                'часов') . ' назад';
    }

    return $diff_minutes_count . ' ' . get_noun_plural_form($diff_minutes_count, 'минута', 'минуты',
            'минут') . ' назад';
}

function get_custom_time_format($time_data)
{
    $date_and_time = date_create($time_data);
    return date_format($date_and_time, 'd.m.Y H:i');
}

function get_content_types($db_connect)
{
    $sql_content_types = 'SELECT type_name, type_icon FROM content_types';
    $result_content_types = mysqli_query($db_connect, $sql_content_types);
    if ($result_content_types === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }
    return mysqli_fetch_all($result_content_types, MYSQLI_ASSOC);
}

function get_posts($db_connect)
{
    $sql_posts = 'SELECT p.created_at, p.title, p.content, p.cite_author, ct.type_name, ct.type_icon, '
        . 'u.name, u.avatar '
        . 'FROM posts AS p '
        . 'JOIN content_types AS ct ON ct.id = p.content_type '
        . 'JOIN users as u ON u.id = p.author_id '
        . 'ORDER BY p.views_counter DESC '
        . 'LIMIT 6;';
    $result_posts = mysqli_query($db_connect, $sql_posts);
    if ($result_posts === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }
    return mysqli_fetch_all($result_posts, MYSQLI_ASSOC);
}
