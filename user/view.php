<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}
include "../config/db.php";

// Check if the file ID is provided
if (isset($_GET['id'])) {
    $fileId = $_GET['id'];

    // Fetch file from database
    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        $filePath = '../Files/' . $file['file_name'];
        
        if (file_exists($filePath)) {
            // Display image or text content
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo '<img src="' . $filePath . '" alt="File Image" style="max-width:100%;">';
            } elseif ($fileExtension === 'txt') {
                echo '<pre>' . htmlspecialchars(file_get_contents($filePath)) . '</pre>';
            } elseif ($fileExtension === 'pdf') {
                // Display PDF in an iframe
                echo '<iframe src="' . $filePath . '" width="100%" height="600px"></iframe>';
            } else {
                echo "Cannot preview this file type.";
            }
        } else {
            echo "File not found.";
        }
    } else {
        echo "No file found with this ID.";
    }
} else {
    echo "Invalid request.";
}
?>
