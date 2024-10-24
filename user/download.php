<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
// Check if file name is provided
if (isset($_GET['file_name'])) {
    $fileName = $_GET['file_name'];
    $filePath = '../Files/' . $fileName;

    if (file_exists($filePath)) {
        // Force download the file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
