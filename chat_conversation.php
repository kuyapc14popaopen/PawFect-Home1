<?php
session_start();
require 'connection.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$currentUserId = $_SESSION['id'];
$chatUserId = $_GET['user_id'];
$chatUserName = urldecode($_GET['user_name']); // Decode the username from the URL

// Function to fetch messages between the current user and the selected user
function fetchConversation($currentUserId, $chatUserId)
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT m.id, m.sender_id, m.receiver_id, m.message, m.timestamp, 
               u1.name as sender_name, u2.name as receiver_name
        FROM messages m
        JOIN users u1 ON m.sender_id = u1.id
        JOIN users u2 ON m.receiver_id = u2.id
        WHERE (m.sender_id = ? AND m.receiver_id = ?)
           OR (m.sender_id = ? AND m.receiver_id = ?)
        ORDER BY m.timestamp ASC
    ");
    $stmt->bind_param("iiii", $currentUserId, $chatUserId, $chatUserId, $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    $stmt->close();

    return $messages;
}

$messages = fetchConversation($currentUserId, $chatUserId);

// Function to send a message
function sendMessage($senderId, $receiverName, $message)
{
    global $conn;
    
    // Retrieve receiver's user ID based on the provided name
    $stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
    $stmt->bind_param("s", $receiverName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "Receiver not found.";
    }

    $row = $result->fetch_assoc();
    $receiverId = $row['id'];

    $stmt->close();

    // Insert message into the database
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $senderId, $receiverId, $message);

    if ($stmt->execute()) {
        return "Message sent successfully.";
    } else {
        return "Failed to send message.";
    }

    $stmt->close();
}

// Check if the message is being sent
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = $_POST['message'];
    $result = sendMessage($currentUserId, $chatUserName, $message);
    echo $result;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Conversation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 1.5em;
            font-weight: bold;
        }

        .back-button {
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .back-icon {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(135deg);
            margin-right: 5px;
        }

        #messages_container {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #e9ebee;
        }

        .message-container {
            padding: 10px;
            margin: 10px 0;
            border-radius: 10px;
            max-width: 75%;
            word-wrap: break-word;
        }

        .sent {
            background-color: #007bff;
            color: white;
            align-self: flex-end;
        }

        .received {
            background-color: #f1f1f1;
            color: black;
            align-self: flex-start;
        }

        .chat-footer {
            padding: 10px;
            background-color: #f4f4f9;
            display: flex;
            border-top: 1px solid #ddd;
        }

        .chat-footer input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }

        .chat-footer button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .chat-footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <button class="back-button" onclick="window.location.href='view_messages.php'">
                <span class="back-icon"></span>
                Back
            </button>
            Chat with <?= htmlspecialchars($chatUserName) ?>
        </div>
        <div id="messages_container">
            <?php foreach ($messages as $msg): ?>
                <?php
                    $isReceived = $msg['receiver_id'] == $currentUserId;
                    $msgClass = $isReceived ? 'received' : 'sent';
                    $name = $isReceived ? $msg['sender_name'] : 'You';
                ?>
                <div class="message-container <?= $msgClass ?>">
                    <p><strong><?= htmlspecialchars($name) ?>:</strong> <?= htmlspecialchars($msg['message']) ?></p>
                    <small><?= $msg['timestamp'] ?></small>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-footer">
            <input type="text" id="messageInput" placeholder="Type a message...">
            <button onclick="sendMessage()">
            Send
        </button>
    </div>
</div>

<script>
    function sendMessage() {
        const messageInput = document.getElementById('messageInput');
        const message = messageInput.value.trim();

        if (message === '') {
            return;
        }

        // Send the message via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'chat_conversation.php?user_id=<?= $chatUserId ?>&user_name=<?= urlencode($chatUserName) ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    if (response === 'Message sent successfully.') {
                        // Reload the page to update the message list
                        location.reload();
                    } else {
                        alert(response); // Display error message if any
                    }
                } else {
                    alert('Failed to send message.');
                }
            }
        };
        xhr.send('message=' + encodeURIComponent(message));
    }
</script>

</body>
</html>
