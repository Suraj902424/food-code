<!DOCTYPE html>
<html>
<head>
    <title>Simple PHP Chatbot</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        #chatbox { width: 400px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 5px; }
        .user, .bot { margin: 10px 0; }
        .bot { color: blue; }
    </style>
</head>
<body>
    <div id="chatbox">
        <div id="chatlog"></div>
        <input type="text" id="userInput" placeholder="Type a message..." />
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
        function sendMessage() {
            var userText = document.getElementById("userInput").value;
            var chatlog = document.getElementById("chatlog");

            // Show user message
            chatlog.innerHTML += "<div class='user'><strong>You:</strong> " + userText + "</div>";

            // Send to PHP via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "chat.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                var botResponse = this.responseText;
                chatlog.innerHTML += "<div class='bot'><strong>Bot:</strong> " + botResponse + "</div>";
                document.getElementById("userInput").value = "";
            };
            xhr.send("message=" + encodeURIComponent(userText));
        }
    </script>
</body>
</html>
