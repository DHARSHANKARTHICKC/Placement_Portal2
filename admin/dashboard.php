<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <span class="navbar-brand">
            Placement Portal - Admin
        </span>

        <a href="logout.php" class="btn btn-light">
            Logout
        </a>

    </div>
</nav>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <h2>
                Welcome,
                <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
            </h2>

            <hr>

            <h4>Admin Dashboard</h4>

            <p>
                You can now manage companies, students, and applications.
            </p>

            <div class="row mt-4">

                <div class="col-md-3">
                    <a href="add_company.php" class="btn btn-primary w-100">
                        Add Company
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="companies.php" class="btn btn-success w-100">
                        Manage Companies
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="students.php" class="btn btn-warning w-100">
                        Students
                    </a>
                </div>

                <div class="col-md-3">
                    <a href="applications.php" class="btn btn-dark w-100">
                        Applications
                    </a>
                </div>
                <div class="col-md-3">

                    <a href="analytics.php"
                    class="btn btn-info w-100 text-white">

                    Analytics

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
