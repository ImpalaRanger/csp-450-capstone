<?php

include '../main.php';
session_start();


$id = $_SESSION['id'];

$msg = $_POST['msg'];
$convo_id = $_POST['currentConvoId'];

$stmt = $con->prepare('INSERT INTO `messages`
    (`id`, `conversation_id`, `sender_id`, `msg`, `submit_date`) VALUES (null,?,?,?,?)');
$stmt->bind_param("iiss", $convo_id, $id, $msg, date('Y-m-d H:i:s'));
$stmt->execute();

echo "from post_message: currentConvoId: " . $convo_id;
echo "msg: " . $msg;
echo "id: " . $id;