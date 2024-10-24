<?php
session_start();

// Static credentials 
$valid_username = 'username';
$valid_password = 'password';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Set session to logged in
        $_SESSION['loggedin'] = true;
        header('Location: dashboard.php');
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
        <h1 class="heading">Login to Access Documents</h1>
        <hr>

        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label class="form-label" for="username">Username: </label>
            <input type="text" id="username" name="username" class="form-control" required />

            <label class="form-label" for="password">Password: </label>
            <input type="password" id="password" name="password" class="form-control" required />

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mt-3">Login</button>
        </form>
    </div>
</body>

</html>
