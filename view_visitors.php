<?php
session_start();
include('dbconn.php'); // Include your database connection file

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.html'); // Redirect to login if not logged in
    exit();
}

// Fetch visitor details from the database
$sql = "SELECT * FROM `tbl_visitor`";
$result = mysqli_query($db, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="assets/Top-logo.jpg" rel="icon" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #007bff;
            color: #fff;
        }
        .table th, .table td {
            padding: 12px;
            text-align: center;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Visitor Details</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Reason</th>
                        <th>Person to Visit</th>
                        <th>Date of Visit</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($visitor = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$visitor['id']}</td>
                                    <td>{$visitor['name']}</td>
                                    <td>{$visitor['email']}</td>
                                    <td>{$visitor['phone']}</td>
                                    <td>{$visitor['reason']}</td>
                                    <td>{$visitor['person_to_visit']}</td>
                                    <td>{$visitor['date_visit']}</td>
                                    <td><img src='{$visitor['photo']}' alt='Visitor Photo' style='width:50px; height:auto;'></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No visitors found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="index.html" class="btn btn-primary btn-back">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>