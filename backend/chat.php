<?php
// chat.php

// Database connection settings
    $host = 'localhost';
    $dbname = 'heavyhire';
    $username = 'root';
    $password = '';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check the action parameter
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'fetch') {
        fetchMessages();
    } elseif ($_POST['action'] === 'send') {
        saveMessage();
    }
}

// Function to fetch messages from the database
function fetchMessages()
{
    global $pdo;

    $sender = $_POST['sender'];
    $recipient = $_POST['recipient'];

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE (sender = :sender AND recipient = :recipient) OR (sender = :recipient AND recipient = :sender) ORDER BY timestamp ASC");
    $stmt->bindParam(':sender', $sender, PDO::PARAM_STR);
    $stmt->bindParam(':recipient', $recipient, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all rows as an associative array
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Generate the HTML markup for the messages
    $output = '';
    foreach ($messages as $message) {
        $output .= '<div>';
        $output .= '<strong>' . $message['sender'] . '</strong>: ' . $message['message'];
        $output .= '</div>';
    }

    // Return the HTML markup
    echo $output;
}

// Function to save a message to the database
function saveMessage()
{
    global $pdo;

    $sender = $_POST['sender'];
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];

    // Prepare and execute the SQL statement
    $stmt = $pdo->prepare("INSERT INTO messages (sender, recipient, message) VALUES (:sender, :recipient, :message)");
    $stmt->bindParam(':sender', $sender, PDO::PARAM_STR);
    $stmt->bindParam(':recipient', $recipient, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
}

