<?php

include '../main.php';
// retrieves messages given a conversation_id---------
$stmt = $con->prepare('SELECT * FROM messages WHERE conversation_id = ?
    ORDER BY submit_date ASC');
$stmt->bind_param("i", $_GET['convo_id']);
$stmt->execute();
$results = $stmt->get_result();
if($results->num_rows > 0) {
    $msg_arr = [];
    foreach ($results as $msg) {
        array_push($msg_arr, $msg);
    }
    echo json_encode($msg_arr);
}//---------------------------------------------------
