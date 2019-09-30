<?php
require_once 'init.php';

if (!isset($_SESSION['user']['id'])) {
    header('Location: /index.php');
    exit();
}

$session_user_id = mysqli_real_escape_string($db_connect, $_SESSION['user']['id']);
$interlocutor_id = $_GET['user_id'] ?? null;

$contact_id = get_contact_id($db_connect, $session_user_id, $interlocutor_id);

if ($contact_id === null) {
    $interlocutor_id = mysqli_real_escape_string($db_connect, $interlocutor_id);
    $sql_insert_contacts = "INSERT INTO contacts (sender_id, receiver_id) VALUES 
                            ($session_user_id, $interlocutor_id),
                            ($interlocutor_id, $session_user_id)";
    mysqli_query($db_connect, $sql_insert_contacts);
}

$interlocutors = null;

$sql_interlocutors = "SELECT u.id, u.name, u.avatar, 
                (SELECT m.created_at
                 FROM messages AS m
                 LEFT JOIN contacts AS c1 ON c1.id = m.contact_id
	             LEFT JOIN contacts AS c2 ON c2.id = m.contact_id
                 WHERE (c1.sender_id = $session_user_id AND c1.receiver_id = u.id) 
                 OR (c2.sender_id = u.id AND c2.receiver_id = $session_user_id)
                 ORDER BY m.created_at DESC LIMIT 1) AS last_message_date
                FROM contacts AS c
                JOIN users AS u ON c.receiver_id = u.id
                WHERE c.sender_id = $session_user_id";
$contacts_result = mysqli_query($db_connect, $sql_interlocutors);
if ($contacts_result) {
    $interlocutors = mysqli_fetch_all($contacts_result, MYSQLI_ASSOC);
}

$messages = [];

if (isset($interlocutor_id)) {
    $interlocutor_id = mysqli_real_escape_string($db_connect, $interlocutor_id);
    $sql_messages = "SELECT u.id, u.name, u.avatar, m.created_at, m.message
                    FROM messages AS m
                    LEFT JOIN contacts AS c1 ON c1.id = m.contact_id
                    LEFT JOIN contacts AS c2 ON c2.id = m.contact_id
                    JOIN contacts AS c ON c.id = m.contact_id
                    JOIN users AS u ON c.sender_id = u.id
                    WHERE (c1.sender_id = $session_user_id AND c1.receiver_id = $interlocutor_id) 
                    OR (c2.sender_id = $interlocutor_id AND c2.receiver_id = $session_user_id)
                    ORDER BY m.created_at";
    $messages_result = mysqli_query($db_connect, $sql_messages);
    if ($messages_result) {
        $messages = mysqli_fetch_all($messages_result, MYSQLI_ASSOC);
    }

}

$error = [];

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

    $message_input = '';
    $receiver_id = null;

    if (isset($_POST['message'], $_POST['receiver-id'])) {
        $message_input = trim($_POST['message']);
        $receiver_id = (int)$_POST['receiver-id'];
    }
    $error = validate_message($db_connect, $message_input, $receiver_id, $session_user_id);

    $referer_link = $_SERVER['HTTP_REFERER'] ?? '/messages.php';

    if (empty($error)) {
        $sql_insert_message = 'INSERT INTO messages (message, contact_id) VALUES (?, ?)';
        db_insert_data($db_connect, $sql_insert_message, [$message_input, $contact_id]);
        header('Location:' . $referer_link);
        exit();
    }
}

$page_content = include_template('messages.php',
    [
        'interlocutors' => $interlocutors,
        'interlocutor_id' => $interlocutor_id,
        'messages' => $messages,
        'session_user_id' => $session_user_id,
        'error' => $error
    ]);

$layout_content = include_template('layout.php',
    [
        'content' => $page_content,
        'is_messages' => true,
        'main_class' => 'page__main--messages',
        'title' => 'readme: личные сообщения'
    ]);

print($layout_content);

