<?php
session_start();

if (!isset($_SESSION['uploading']) || $_SESSION['uploading'] !== true) {
    header('Location: login.php');
    exit();
}

$success_message = (isset($_SESSION['success_message']))  ? $_SESSION['success_message'] : '';
$error_message = (isset($_SESSION['error_message']))  ? $_SESSION['error_message'] : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Wallet</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet"
        href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 10%;
            border: 1px solid lightgray;
            border-radius: 10px;
            padding: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="form-card">
            <a href="logout.php" class="btn btn-danger">Logout</a>
            <h1 class="heading">Welcome to your Document Vault, Please upload file.</h1>
            <hr>
            <div class="message">
                <?php if($success_message): ?>
                    <p class="alert alert-success"><?=$success_message?></p>
                <?php elseif($error_message): ?>
                    <p class="alert alert-danger"><?=$error_message?></p>
                <?php else: ?>
                    <p class="alert alert-info">Please upload your document.</p>
                <?php endif; ?>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label class="form-label" for="fileTitle">File Title: </label>
                <input type="text" id="fileTitle" name="fileTitle" class="form-control" placeholder="Enter the Title of the file" />
            
                <label class="form-label" for="customFile">Select File</label>
                <input type="file" class="form-control" id="customFile" name="customFile" />
            
                <label class="form-label" for="secret">Enter Your Secret: </label>
                <input type="text" id="secret" name="secret" class="form-control" placeholder="Enter your secret to successfully upload your file." />
            
                <!-- Submit button -->
                <button data-mdb-ripple-init type="submit" class="btn btn-primary btn-block mt-3">Save</button>
            </form>
            
        </div>
    </div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>

<?php
unset($_SESSION['error_message']);
unset($_SESSION['success_message']);
?>