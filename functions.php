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
