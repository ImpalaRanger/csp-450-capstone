<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="messaging.css">



    <title>Messages</title>
</head>
<body>
<header>
<button onclick="">Messages</button>
<button onclick="window.location.href='../dash.php';">Dashboard</button>
</header>
    
    <?php


        session_start();
        include '../main.php';

        $_SESSION['currentConvoId'];
        $currentConvoId;
        $conversations = [];

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
    ?>

<div class="container">
    <h1>Messages</h1>
    <div class="chat-container">
        <div class="chat-tab chat-conversations">
            <form class='chat-conversation-selector' id='chat-conversation-selector'
            onchange='getConversation()'>
                <?php // processes conversation selectors
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
                        // retrieves first name of opposite user being messaged
                        $messaged_user = $data['first_name'];


                        echo "<div class='option-case'>";
                        echo "<input type='radio' id='convo_with_" . $messaged_user
                            ."' class='chat-convo-selector-option' name='convo' value='".$conversation['id']."'/>\n";
                        echo "<label class='convo-option' for='convo_with_" . $messaged_user
                        ."'>".$messaged_user."</label>\n";
                        echo "<br>\n";
                        echo "</div>";
                    }
                ?>
            </form>
        </div>
        <div class="chat-tab conversation" id="conversation">
            <div class="convo-display" id="convo-display">

            </div>
            <div class="send-message-case">
                <div name="sendMessage" class="chat-send-message" >
                    <input type="text" class="chat-box" id="msg" name="msg" placeholder="Message">
                    <button class="btn" id="sendBtn" onclick="postMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // global variable for tracking which conversation is currently open
    let currentConvoId = -1;

    // AJAX request for loading messages when user selects a conversation
    function getConversation() {
        var convo_id = document.querySelector('input[name=convo]:checked').value;
        console.log(convo_id + " from getConversation()");
        currentConvoId = convo_id;
        
        var xhttp;
        if (convo_id == "") {
            document.getElementById("convo-display").innerHTML = "No messages to load.";
            return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            document.getElementById("convo-display").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "fetch_convo.php?convo_id="+currentConvoId, true);
        xhttp.send();
    }

    // AJAX request for retrieving most recent message in conversation selector
    function getLatest() {
    }

    // function that posts message to database
    function postMessage() {

        var msg = document.getElementById('msg').value;
        //console.log('here:' + msg);
        var params = "currentConvoId="+currentConvoId+"&msg="+msg;
        //console.log(params);
        let xmr = new XMLHttpRequest();
        xmr.open("POST", "post_message.php");
        xmr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmr.send(params);
        xmr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                getConversation();
                document.getElementById('msg').value = "";
            }
        }
    }
</script>


<footer></footer>
</body>
</html>
