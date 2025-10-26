<?php

require_once 'assets/php/functions.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pictogram";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Retrieve username from global context
global $usern;

// Get user ID and profile picture
$user_id = getUserIdByUsername($mysqli, $usern);
$profilePicUrl = getUserProfilePicByUsername($mysqli, $usern);

// Function to count reactions
function countReactions($reactions, $type, $id, $reactionType) {
    return isset($reactions[$type][$id][$reactionType]) ? count($reactions[$type][$id][$reactionType]) : 0;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post_content'])) {
        // Handle new post
        $user_id = getUserIdByUsername($mysqli, $usern);
        $post_content = $mysqli->real_escape_string($_POST['post_content']);
        $topic = $mysqli->real_escape_string($_POST['topic']);

        $stmt = $mysqli->prepare("INSERT INTO tp (user_id, content, topic) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare statement failed: " . $mysqli->error);
        }
        $stmt->bind_param('sss', $user_id, $post_content, $topic);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        header("Location: top_t.php");
        exit();
    } elseif (isset($_POST['delete_post_id'])) {
        // Handle delete post
        $post_id = $mysqli->real_escape_string($_POST['delete_post_id']);
        
        // Verify user ownership
        $stmt = $mysqli->prepare("SELECT user_id FROM tp WHERE id = ?");
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        $stmt->close();

        if ($post && $post['user_id'] == $user_id) {
            // Delete comments and post
            $stmt = $mysqli->prepare("DELETE FROM tc WHERE post_id = ?");
            $stmt->bind_param('i', $post_id);
            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }
            $stmt->close();

            $stmt = $mysqli->prepare("DELETE FROM tp WHERE id = ? AND user_id = ?");
            $stmt->bind_param('ii', $post_id, $user_id);
            if (!$stmt->execute()) {
                die("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        } else {
            echo "You are not authorized to delete this post.";
        }
        header("Location: top_t.php");
        exit();
    } elseif (isset($_POST['react_post_id'])) {
        // Handle react to post
        $post_id = $mysqli->real_escape_string($_POST['react_post_id']);
        $reaction = $mysqli->real_escape_string($_POST['reaction']);

        // Delete existing reaction if it exists
        $stmt = $mysqli->prepare("DELETE FROM tl WHERE user_id = ? AND post_id = ?");
        $stmt->bind_param('ii', $user_id, $post_id);
        $stmt->execute();
        $stmt->close();

        // Insert new reaction
        $stmt = $mysqli->prepare("INSERT INTO tl (user_id, post_id, reaction) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare statement failed: " . $mysqli->error);
        }
        $stmt->bind_param('iis', $user_id, $post_id, $reaction);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        header("Location: top_t.php");
        exit();
    } elseif (isset($_POST['comment_content'])) {
        // Handle add comment
        $post_id = $mysqli->real_escape_string($_POST['post_id']);
        $comment_content = $mysqli->real_escape_string($_POST['comment_content']);

        $stmt = $mysqli->prepare("INSERT INTO tc (post_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $post_id, $user_id, $comment_content);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        header("Location: top_t.php");
        exit();
    } elseif (isset($_POST['react_comment_id'])) {
        // Handle react to comment
        $comment_id = $mysqli->real_escape_string($_POST['react_comment_id']);
        $reaction = $mysqli->real_escape_string($_POST['reaction']);

        // Delete existing reaction if it exists
        $stmt = $mysqli->prepare("DELETE FROM tl WHERE user_id = ? AND comment_id = ?");
        $stmt->bind_param('ii', $user_id, $comment_id);
        $stmt->execute();
        $stmt->close();

        // Insert new reaction
        $stmt = $mysqli->prepare("INSERT INTO tl (user_id, comment_id, reaction) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Prepare statement failed: " . $mysqli->error);
        }
        $stmt->bind_param('iis', $user_id, $comment_id, $reaction);
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
        header("Location: top_t.php");
        exit();
    }
}

// Fetch all posts
$posts = $mysqli->query("SELECT tp.id AS post_id, users.username, tp.user_id, tp.content, tp.topic, tp.created_at FROM tp JOIN users ON tp.user_id = users.id ORDER BY tp.created_at DESC");
if (!$posts) {
    die("Query failed: " . $mysqli->error);
}

// Fetch all comments
$comments_result = $mysqli->query("SELECT * FROM tc");
if (!$comments_result) {
    die("Query failed: " . $mysqli->error);
}
$comments = [];
while ($row = $comments_result->fetch_assoc()) {
    $comments[$row['post_id']][] = $row;
}

// Fetch all reactions
$reactions_result = $mysqli->query("SELECT * FROM tl");
if (!$reactions_result) {
    die("Query failed: " . $mysqli->error);
}
$reactions = [];
while ($row = $reactions_result->fetch_assoc()) {
    if ($row['post_id'] != null) {
        $reactions['post'][$row['post_id']][] = $row;
    } else if ($row['comment_id'] != null) {
        $reactions['comment'][$row['comment_id']][] = $row;
    }
}

// Random quotes
$quotes = [
    "The only way to do great work is to love what you do. – Steve Jobs",
    "Life is what happens when you're busy making other plans. – John Lennon",
    "Get your facts first, then you can distort them as you please. – Mark Twain",
    "You have within you right now, everything you need to deal with whatever the world can throw at you. – Brian Tracy",
    "The purpose of our lives is to be happy. – Dalai Lama"
];
$random_quote = $quotes[array_rand($quotes)];

// Close connection
$mysqli->close();
?>
