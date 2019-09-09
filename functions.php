<?php
function db_fetch_data($link, $sql, $data = [], $is_single = false)
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($link) . ' --- ' . mysqli_error($link);
        exit($query_error);
    }

    if ($is_single) {
        return mysqli_fetch_assoc($result);
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function db_insert_data($link, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $result = mysqli_insert_id($link);
    } else {
        $query_error = 'Ошибка №' . mysqli_errno($link) . ' --- ' . mysqli_error($link);
        exit($query_error);
    }

    return $result;
}

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

function get_mysqli_result($db_connect, $sql)
{
    $result = mysqli_query($db_connect, $sql);
    if ($result === false) {
        $query_error = 'Ошибка №' . mysqli_errno($db_connect) . ' --- ' . mysqli_error($db_connect);
        exit($query_error);
    }

    return $result;
}

function get_content_types($db_connect)
{
    $sql = 'SELECT id, type_name, type_icon FROM content_types';
    $result = get_mysqli_result($db_connect, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function is_type_exist($arrays, $type)
{
    return in_array($type, array_column($arrays, 'id'), true);
}

function get_posts($db_connect, $type)
{
    $data = [];
    $sql = 'SELECT p.id, p.created_at, p.title, p.content, p.cite_author, ct.type_name, ct.type_icon, u.name, u.avatar
            FROM posts AS p
            JOIN content_types AS ct
                ON ct.id = p.content_type
            JOIN users as u
                ON u.id = p.author_id ';
    if (isset($type)) {
        $sql .= 'WHERE p.content_type = ? ';
        $data[] = $type;
    }
    $sql .= 'ORDER BY p.views_counter DESC LIMIT 6;';

    return db_fetch_data($db_connect, $sql, $data);
}

function get_post($db_connect, $id)
{
    $sql = 'SELECT p.id, p.created_at, p.title, p.content, p.cite_author, p.views_counter, p.is_repost, p.content_type, 
            p.author_id, u.name, u.avatar, u.created_at as user_created_at
            FROM posts as p
            JOIN users as u
                ON u.id = p.author_id 
            WHERE p.id = ?';

    return db_fetch_data($db_connect, $sql, [$id], true);
}

function get_publications_count($db_connect, $user_id)
{
    $sql = 'SELECT COUNT(id) as count
            FROM posts
            WHERE author_id = ?';

    return db_fetch_data($db_connect, $sql, [$user_id], true)['count'] ?? 0;
}

function get_subscriptions_count($db_connect, $user_id)
{
    $sql = 'SELECT COUNT(id) as count
            FROM subscriptions
            WHERE author_id = ?';

    return db_fetch_data($db_connect, $sql, [$user_id], true)['count'] ?? 0;
}

function get_hashtags_from_db($db_connect)
{
    $sql = 'SELECT hashtag FROM hashtags';
    $result = get_mysqli_result($db_connect, $sql);

    $assoc_array = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return array_column($assoc_array, 'hashtag');
}

function db_insert_uniq_hashtags($db_connect, $string_tags)
{
    $post_hashtags_array = explode(' ', $string_tags);
    $uniq_hashtags = array_diff($post_hashtags_array, get_hashtags_from_db($db_connect));
    $array_count = count($uniq_hashtags);

    if ($array_count > 0) {
        $sql = 'INSERT INTO hashtags (hashtag) VALUES';
        for ($i = 0; $i < $array_count; $i++) {
            if ($array_count === 1 || $i === $array_count - 1) {
                $sql .= ' (?)';
            } else {
                $sql .= ' (?), ';
            }
        }
        $stmt = db_get_prepare_stmt($db_connect, $sql, $uniq_hashtags);
        mysqli_stmt_execute($stmt);
    }
}

function db_insert_hashtag_posts_connection($db_connect, $string_tags, $post_id)
{
    $string_tags = mysqli_real_escape_string($db_connect, $string_tags);
    $post_id = mysqli_real_escape_string($db_connect, $post_id);
    $string_tags_with_commas = "'" . str_replace(' ', "', '", $string_tags) . "'";
    $sql = "INSERT INTO hashtags_posts (hashtag_id, post_id) 
            SELECT id, $post_id FROM hashtags WHERE hashtag IN ($string_tags_with_commas)";
    get_mysqli_result($db_connect, $sql);
}

function get_post_val($name)
{
    return $_POST[$name] ?? '';
}

function validate_filled($name, $input_name)
{
    if (empty($name)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    return null;
}

// TODO: Переделать функцию is_url_exists

function is_url_exists($url)
{
    $response_code_header = @get_headers($url)[0] ?? '';
    return stripos($response_code_header, '200 OK') !== false;
}

function check_link_mime_type($url, $input_name)
{
    $file = file_get_contents($url);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_buffer($finfo, $file);

    if ($file_type !== 'image/png' && $file_type !== 'image/jpeg' && $file_type !== 'image/gif') {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Выбранный файл не является png, jpg/jpeg или gif.'
        ];
    }

    return null;
}

function validate_photo_url($url, $input_name)
{

    if ($_FILES['upload-file']['error'] !== UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($url === '') {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Укажите ссылку для загрузки файла или выберите файл для загрузки.'
        ];
    }

    if (!empty($url)) {

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return [
                'input_name' => $input_name,
                'input_error_desc' => 'Неверный формат адреса картинки.'
            ];
        }

        if (is_url_exists($url) === false) {
            return [
                'input_name' => $input_name,
                'input_error_desc' => 'Невозможно загрузить файл.'
            ];
        }

        return check_link_mime_type($url, $input_name);
    }

    return null;
}

function validate_uploaded_file($file_data, $input_name)
{
    if ($_POST['photo-url'] !== '' && $file_data['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file_data['name'] === '') {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Выберите файл для загрузки.'
        ];
    }

    if ($file_data['error'] !== UPLOAD_ERR_OK) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Не удалось загрузить файл.'
        ];
    }

    if ($file_data['size'] > 2097152) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Файл слишком большой. Загрузите файл до 2МБ.'
        ];
    }

    $tmp_name = $file_data['tmp_name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== 'image/png' && $file_type !== 'image/jpeg' && $file_type !== 'image/gif') {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Выбранный файл не является png, jpg/jpeg или gif.'
        ];
    }

    return null;
}

function get_link_file_ext($url)
{
    $file = file_get_contents($url);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_buffer($finfo, $file);

    switch ($file_type) {
        case 'image/png':
            return 'png';
        case 'image/jpeg':
            return 'jpg';
        case 'image/gif':
            return 'gif';
    }

    return null;
}

function validate_video_url($url, $input_name)
{
    if (empty($url)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Неверный формат адреса видео.'
        ];
    }

    if (!check_youtube_url($url)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Нет такого видео'
        ];
    }

    return null;
}

function validate_link($url, $input_name)
{
    if (empty($url)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Неверный формат cсылки.'
        ];
    }

    return null;
}

function is_email_exists($db_connect, $email)
{
    $email = mysqli_real_escape_string($db_connect, $email);
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_num_rows(get_mysqli_result($db_connect, $sql));

    return $result > 0;
}

function validate_email($db_connect, $email, $input_name)
{
    if (empty($email)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Неверный формат email.'
        ];
    }

    if (is_email_exists($db_connect, $email)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Пользователь с этим email уже зарегистрирован.'
        ];
    }

    return null;
}

function validate_password_repeat($pass, $pass_repeat, $input_name)
{
    if (empty($pass_repeat)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if ($pass !== $pass_repeat) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Повтор пароля не совпадает с изначальным паролем.'
        ];
    }

    return null;
}

function validate_avatar($file_data, $input_name)
{
    if ($file_data['name'] === '') {
        return null;
    }

    if ($file_data['error'] !== UPLOAD_ERR_OK) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Не удалось загрузить файл.'
        ];
    }

    if ($file_data['size'] > 307200) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Файл слишком большой. Загрузите файл до 300КБ.'
        ];
    }

    $tmp_name = $file_data['tmp_name'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);
    if ($file_type !== 'image/png' && $file_type !== 'image/jpeg' && $file_type !== 'image/gif') {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Выбранный файл не является png, jpg/jpeg или gif.'
        ];
    }

    return null;
}

function validate_ext_email($db_connect, $email)
{
    if (empty($email)) {
        return [
            'error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return [
            'error_desc' => 'Неверный формат email.'
        ];
    }

    if (!is_email_exists($db_connect, $email)) {
        return [
            'error_desc' => 'Нет пользователя с таким email.'
        ];
    }

    return null;
}

function check_user_password($db_connect, $email, $password) {
    $email = mysqli_real_escape_string($db_connect, $email);
    $sql = "SELECT password FROM users WHERE email = '$email'";
    $result_password = mysqli_fetch_assoc(get_mysqli_result($db_connect, $sql))['password'];

    return password_verify($password, $result_password);
}

function validate_ext_password($db_connect, $email, $password)
{
    if (empty($password)) {
        return [
            'error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (!check_user_password($db_connect, $email, $password)) {
        return [
            'error_desc' => 'Неверный пароль.'
        ];
    }

    return null;
}

function validate_login_email($db_connect, $email, $input_name)
{
    if (empty($email)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Неверный формат email.'
        ];
    }

    if (!is_email_exists($db_connect, $email)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Нет пользователя с таким email.'
        ];
    }

    return null;
}

function validate_login_password($db_connect, $email, $password, $input_name)
{
    if (empty($password)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Это поле должно быть заполнено.'
        ];
    }

    if (!check_user_password($db_connect, $email, $password)) {
        return [
            'input_name' => $input_name,
            'input_error_desc' => 'Неверный пароль.'
        ];
    }

    return null;
}
