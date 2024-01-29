<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user's message from the POST request
    $userInput = $_POST["userInput"];

    // Simple example: Echo back the user's message
    echo "I received your message: " . $userInput;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chatbot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #chat-container {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        #chat-messages {
            height: 200px;
            overflow-y: scroll;
            padding: 10px;
            background-color: #fff;
        }

        #user-input {
            display: flex;
            padding: 10px;
            background-color: #eee;
        }

        #message-input {
            flex-grow: 1;
            margin-right: 10px;
            padding: 6px;
        }

        #send-button {
            padding: 6px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <div id="chat-messages"></div>
        <div id="user-input">
            <input type="text" id="message-input" placeholder="Type a message...">
            <button id="send-button" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function sendMessage() {
            var userInput = document.getElementById("message-input").value;

            // Display user's message
            appendMessage("You", userInput);

            // Send user's message to the server (PHP)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chatbot.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Display chatbot's response
                    var chatbotResponse = xhr.responseText;
                    appendMessage("Chatbot", chatbotResponse);
                }
            };
            xhr.send("userInput=" + userInput);

            // Clear the input field
            document.getElementById("message-input").value = "";
        }

        function appendMessage(sender, message) {
            var chatMessages = document.getElementById("chat-messages");
            var newMessage = document.createElement("div");
            newMessage.innerHTML = "<strong>" + sender + ":</strong> " + message;
            chatMessages.appendChild(newMessage);

            // Scroll to the bottom of the chat
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</body>
</html>
