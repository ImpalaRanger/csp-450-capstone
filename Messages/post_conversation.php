<?php

include '../main.php';

$id = $_SESSION['id'];
$desiredUserConnect = $_POST['desiredConnect'];
echo $desiredUserConnect;
$stmt1 = $con->prepare('SELECT * FROM users WHERE email=?');
$stmt1->bind_param('s', $desiredUserConnect);
$stmt1->execute();
$result = $stmt1->get_result();
$data = $result->fetch_assoc();


$stmt = $con->prepare('INSERT INTO `conversations`(`id`, `sender_id`, `receiver_id`) VALUES (null, ?,?)');
$stmt->bind_param("ii", $id, $data['id']);
$stmt->execute();

