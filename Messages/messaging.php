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


        include '../main.php';

    ?>

<div class="container">
    <h1>Messages</h1>
    <div class="chat-container">
        <div class="chat-tab chat-conversations">
            <form class='chat-conversation-selector' id='chat-conversation-selector'
            onchange='getConversation()'>

            </form>
            <div class="new-convo-case">
                <button class="btn" onclick="addConversation()">New</button>
                <input type="text" id="new_convo_email" name="new_convo_email" placeholder="Enter email here" value="admin@gmail.com">
            </div>
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
    // global variable for holding user id across script
    const userId = <?php echo $_SESSION['id']; ?>;
    // global variable for tracking list of emails user is connected to
    let connectedUsers = [];

    // general use ajax get function 
    function ajaxGet(url, cFunction, async) {
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                cFunction(this);
            }
        };
        xhttp.open("GET", url, async);
        xhttp.send();
    }

    function getConnected(xhttp) {
        //console.log(xhttp.responseText);
        connectedUsers = JSON.parse(xhttp.responseText);
        console.log(connectedUsers);
        
    }

    // callback for ajax req
    function getConversations(xhttp) {
        document.getElementById('chat-conversation-selector').innerHTML = xhttp.responseText;
    }

    // callback for ajax req
    function setConversation(xhttp) {
        document.getElementById("convo-display").innerHTML = "";
        console.log("response: " + xhttp.responseText);
        let messages = JSON.parse(xhttp.responseText);
        messages.forEach((message) =>{
            let indivMessage = document.createElement('div');
            if (message.sender_id == userId) {
                indivMessage.className = "message message-right";
                indivMessage.style.cssText = 'width:fit-content;max-width:70%;border: solid black 1px;background-color: #ccc;border-radius: 5px;padding:5px;margin-bottom:5px;margin-left:auto;';
            }
            else {
                indivMessage.className = "message message-left";
                indivMessage.style.cssText = 'width:fit-content;max-width:70%;border: solid black 1px;background-color: #20bee5;border-radius: 5px;padding:5px;margin-bottom:5px;';
                
            }
            indivMessage.innerText = message.msg;
            document.getElementById('convo-display').appendChild(indivMessage);
        });


        var display = document.getElementById('convo-display');
        display.scrollTop = display.scrollHeight;
    }

    function getConversation() {
        
        var convo_id = document.querySelector('input[name=convo]:checked').value;
        console.log(convo_id + " from getConversation()");
        currentConvoId = convo_id;
        
        ajaxGet("fetch_convo.php?convo_id="+currentConvoId, setConversation, true);
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

    // adds a new conversation
    function addConversation() {
        // retrieve value from textbox
        let desiredUserEmail = document.getElementById('new_convo_email').value;
        console.log(desiredUserEmail);
        ajaxGet("fetch_connected.php", getConnected, false);
        
        ajaxGet("fetch_convos.php", getConversations, false);
        console.log(connectedUsers);

        if (connectedUsers.includes(desiredUserEmail)) {
            console.log("Already chatting with that user");

        }
        else {
            // else insert new convo
       
            var params = "desiredConnect="+desiredUserEmail;
            //console.log(params);
            let xmr = new XMLHttpRequest();
            xmr.open("POST", "post_conversation.php");
            xmr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmr.send(params);
            xmr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    ajaxGet("fetch_convos.php", getConversations, false);
                    console.log(this.responseText);
                }
            }
        }


    }

    ajaxGet("fetch_convos.php", getConversations, true);

/*
    setInterval(() => {
        console.log('retreving messages');
        getConversation();
    }, 5000);
*/




</script>


<footer></footer>
</body>
</html>
