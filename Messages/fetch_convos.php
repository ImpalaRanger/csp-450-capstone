<?php // processes conversation selectors
include "../main.php";

$conversations = [];
//tracks users the user is already chatting with
$conversations_names = [];


// fetches conversations the user is involved in
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
        join users on users.id=conversations.receiver_id
            where sender_id=? and receiver_id=?');
        $stmt2->bind_param("ii", $conversation['sender_id'], $conversation['receiver_id']);
    }
    else { // user is receiver
        $stmt2 = $con->prepare('select * from conversations
        join users on users.id=conversations.sender_id
            where receiver_id=? and sender_id=?');
        $stmt2->bind_param("ii", $conversation['receiver_id'], $conversation['sender_id']);
    }
    $stmt2->execute();
    $stmt2_result = $stmt2->get_result();
    $data = $stmt2_result->fetch_assoc();
    // retrieves first name of opposite user being messaged
    $messaged_user = $data['first_name'];
    $messaged_email = $data['email'];
    array_push($conversations_names, $data['email']);
    
    
    echo "<div class='option-case'>";
    echo "<input type='radio' id='convo_with_" . $messaged_user
        ."' class='chat-convo-selector-option' name='convo' value='".$conversation['id']."'  />\n";
    echo "<label class='convo-option' for='convo_with_" . $messaged_user
    ."'>".$messaged_user."\n". $messaged_email    ."</label>\n";
    echo "<br>\n";
    echo "</div>";
}

