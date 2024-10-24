<?php
$app_secret = "secret";
session_start();
include "config/db.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get file title and file data
    $fileTitle = $_POST['fileTitle'];
    $secret = $_POST['secret']; // This is just for checking the secret, not saving it

    if($secret === $app_secret){
    // Check if the file is uploaded
    if (isset($_FILES['customFile']) && $_FILES['customFile']['error'] == 0) {
        $fileName = $_FILES['customFile']['name'];
        $fileTmpName = $_FILES['customFile']['tmp_name'];
        $uploadDir = 'Files/';
        // Generate a file name using bin2hex
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
        
        // $filePath = $uploadDir . basename($fileName);
        $filePath = $uploadDir . $newFileName;

        // Move the uploaded file to the desired directory
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Insert file data into the database
            $stmt = $pdo->prepare("INSERT INTO files (title, file_name, original_file_name, file_type) VALUES (:title, :file_name, :original_file_name, :file_type)");
            $stmt->execute([':title' => $fileTitle, ':file_name' => $newFileName,  ':original_file_name' => $fileName,  ':file_type' => $fileExtension]);



            $_SESSION['success_message'] = "File uploaded and data saved successfully!";
        } else {
            $_SESSION['error_message'] = "Failed to move uploaded file.";
        }
    } else {
        $_SESSION['error_message'] = "No file uploaded or there was an error.";
    }
} else {
    $_SESSION['error_message'] = "Invalid Secret!, Sorry Can not upload File.";
}

header("location: index.php");
exit();
}
?>
