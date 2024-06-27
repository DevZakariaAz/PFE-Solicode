<?php
include "../connection.php";

// Fetch all publications
$query = "SELECT * FROM publication";
$stmt = $conn->prepare($query);
$stmt->execute();
$publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Publications</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .content {
            margin-left: 270px; /* Width of the sidebar + margin */
            padding: 20px;
        }
        .publications-header {
            margin-bottom: 30px;
            color: #333;
        }
        .publications-header h2 {
            font-size: 32px;
            font-weight: bold;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table thead th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-danger {
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-primary {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include '../package/sidebar.html'; ?>

    <div class="content">
        <div class="publications-header">
            <h2>Publications</h2>
            <!-- Button to create a new publication -->
            <a href="create_publication.php" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Add New Publication</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Publication ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $publication): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($publication['publicationid']); ?></td>
                            <td><?php echo htmlspecialchars($publication['titre']); ?></td>
                            <td><?php echo htmlspecialchars($publication['description']); ?></td>
                            <td>
                                <a href="modify_publication.php?publicationid=<?php echo htmlspecialchars($publication['publicationid']); ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <a href="delete_publication.php?id=<?php echo htmlspecialchars($publication['publicationid']); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
