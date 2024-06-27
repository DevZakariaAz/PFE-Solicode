<?php
include "../connection.php";

// Initialize filter variables
$filter_username = isset($_GET['filter_username']) ? $_GET['filter_username'] : '';
$filter_email = isset($_GET['filter_email']) ? $_GET['filter_email'] : '';

// Construct the SQL query with filters
$query = "SELECT * FROM user WHERE 1=1";
if ($filter_username) {
    $query .= " AND username LIKE :filter_username";
}
if ($filter_email) {
    $query .= " AND email LIKE :filter_email";
}


$stmt = $conn->prepare($query);

if ($filter_username) {
    $stmt->bindValue(':filter_username', '%' . $filter_username . '%');
}
if ($filter_email) {
    $stmt->bindValue(':filter_email', '%' . $filter_email . '%');
}


$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        .dashboard-header {
            margin-bottom: 30px;
            color: #333;
        }
        .dashboard-header h2 {
            font-size: 32px;
            font-weight: bold;
        }
        .dashboard-header h3 {
            font-size: 24px;
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <?php include '../package/sidebar.html'; ?>

    <div class="content">
        <div class="dashboard-header">
            <h2>Admin Dashboard</h2>
            <h3>Users</h3>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="filter_username">Username:</label>
                    <input type="text" class="form-control" id="filter_username" name="filter_username" value="<?php echo htmlspecialchars($filter_username); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="filter_email">Email:</label>
                    <input type="text" class="form-control" id="filter_email" name="filter_email" value="<?php echo htmlspecialchars($filter_email); ?>">
                </div>
                
                <div class="form-group col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['userid']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a href="view_user_reviews.php?userid=<?php echo htmlspecialchars($user['userid']); ?>" class="btn btn-info"><i class="fas fa-eye"></i> View Reviews</a>
                                <a href="delete_user.php?id=<?php echo htmlspecialchars($user['userid']); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
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
