<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}

include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fileId = $_POST['file_id'];

    // Fetch file details to delete
    $stmt = $pdo->prepare("SELECT * FROM files WHERE id = :id");
    $stmt->execute([':id' => $fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        // Delete the file from the directory
        $filePath = '../Files/' . $file['file_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the file record from the database
        $stmt = $pdo->prepare("DELETE FROM files WHERE id = :id");
        $stmt->execute([':id' => $fileId]);

        $_SESSION['success_message'] = "File deleted successfully!";
    } else {
        $_SESSION['error_message'] = "File not found.";
    }
}

header('Location: dashboard.php');
exit();
?>
