<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit();
}


include "../config/db.php"; // Database connection

// Fetch all files from the database
$stmt = $pdo->query("SELECT * FROM files ORDER BY uploaded_at DESC");
$files = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
    <style>
        .container {
            margin-top: 10%;
            padding: 20px;
            border: 1px solid lightgray;
            border-radius: 10px;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 5px 10px;
            text-align: center;
        }

        .btn-download {
            background-color: #4CAF50;
            color: white;
        }

        .btn-view {
            background-color: #2196F3;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="heading">Your Document Vault</h1>
        <hr>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-danger">Logout</a>

        <table border="1">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Original File Name</th>
                    <th>File Type</th>
                    <th>Upload Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $file): ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['title']); ?></td>
                    <td><?php echo htmlspecialchars($file['original_file_name']); ?></td>
                    <td><?php echo htmlspecialchars($file['file_type']); ?></td>
                    <td><?php echo $file['uploaded_at']; ?></td>
                    <td class="actions">
                        <a href="view.php?id=<?php echo $file['id']; ?>" class="btn btn-view">View</a>
                        <a href="download.php?file_name=<?php echo $file['file_name']; ?>" class="btn btn-download">Download</a>
                        <form action="delete.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">
                            <input type="hidden" name="file_id" value="<?php echo $file['id']; ?>">
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this file?");
    }
</script>

</body>

</html>
