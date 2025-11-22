<?php
// ---------------------------
// init.php
// Common initialization file
// ---------------------------

// Enable error reporting (good for local dev)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Sanitize a value for safe HTML output
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Safely check if a POST field exists
function get_post($key) {
    return isset($_POST[$key]) ? trim($_POST[$key]) : null;
}

// Safely check if a GET parameter exists
function get_get($key) {
    return isset($_GET[$key]) ? trim($_GET[$key]) : null;
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit();
}

// If you ever need a database, uncomment & configure this:
//
// try {
//     $db = new PDO("sqlite:" . __DIR__ . "/../db/database.sqlite");
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Database error: " . $e->getMessage();
//     exit();
// }

?>
