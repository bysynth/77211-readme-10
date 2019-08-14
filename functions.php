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
