<?php
session_start();

if (isset($_SESSION['uploading']) || $_SESSION['uploading'] == true) {
    header('Location: index.php');
    exit();
}

$app_secret = "secret";
// Static credentials 
$valid_username = 'admin';
$valid_password = 'password';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pair = $_POST['pair'];

    // Validate credentials
    // if ($username === $valid_username && $password === $valid_password) {
    if ($pair === $app_secret) {
        // Set session to logged in
        $_SESSION['uploading'] = true;
        header('Location: index.php');
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet"
        href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
    <style>
        .container {
            margin-top: 10%;
            padding: 20px;
            border: 1px solid lightgray;
            border-radius: 10px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="heading">Login to Upload Documents</h1>
        <hr>

        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label class="form-label" for="password">Pair Name: </label>
            <input type="password" id="password" name="pair" class="form-control" required />

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
        </form>
    </div>
</body>

</html>
