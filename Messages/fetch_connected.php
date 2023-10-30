<?php // fetches emails user is connected with
include "../main.php";

$conversations = [];
$conversations_email = [];

$stmt = $con->prepare("select * from conversations where sender_id = ? OR receiver_id = ?");
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$stmt_result = $stmt->get_result();
if($stmt_result->num_rows > 0) {
    foreach ($stmt_result as $row) {
        array_push($conversations, $row);
    }
}

foreach ($conversations as $conversation) {
    $messaged_user;

    $stmt2;
    if ($conversation['sender_id'] == $id) { // user is sender
        $stmt2 = $con->prepare('select * from conversations
        join users on users.id=conversations.sender_id
            where sender_id=? and users.id=sender_id');
        $stmt2->bind_param("i", $conversation['receiver_id']);
    }
    else { // user is receiver
        $stmt2 = $con->prepare('select * from conversations
        join users on users.id=conversations.receiver_id
            where receiver_id=? and users.id=receiver_id');
        $stmt2->bind_param("i", $conversation['sender_id']);
    }
    $stmt2->execute();
    $stmt2_result = $stmt2->get_result();
    $data = $stmt2_result->fetch_assoc();
    array_push($conversations_email, $data['email']);
}
echo json_encode($conversations_email);