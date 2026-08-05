<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Total Companies
$companyQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM companies");
$totalCompanies = mysqli_fetch_assoc($companyQuery)['total'];

// Jobs Applied
$applicationQuery = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM applications WHERE student_id='$student_id'");
$totalApplications = mysqli_fetch_assoc($applicationQuery)['total'];

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Student Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

<div class="container">

<a class="navbar-brand" href="#">
Placement Portal
</a>

<div class="ms-auto">

<span class="text-white me-3">

Welcome,
<strong><?php echo htmlspecialchars($_SESSION['student_name']); ?></strong>

</span>

<a href="logout.php" class="btn btn-light">
Logout
</a>

</div>

</div>

</nav>

<div class="container mt-4">

<div class="row">

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Companies</h5>

<h2 class="text-primary">

<?php echo $totalCompanies; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Jobs Applied</h5>

<h2 class="text-success">

<?php echo $totalApplications; ?>

</h2>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card text-center shadow">

<div class="card-body">

<h5>Profile Status</h5>

<h2 class="text-warning">

Complete

</h2>

</div>

</div>

</div>

</div>

<hr class="my-5">

<h3>Quick Actions</h3>

<div class="row mt-4">

<div class="col-md-3">

<a href="companies.php" class="btn btn-primary w-100">

View Companies

</a>

</div>

<div class="col-md-3">

<a href="applications.php" class="btn btn-success w-100">

My Applications

</a>

</div>

<div class="col-md-3">

<a href="profile.php" class="btn btn-warning w-100">
My Profile
</a>

</div>

<div class="col-md-3">

<a href="resume.php" class="btn btn-info w-100 text-white">

Upload Resume

</a>

</div>

</div>

<hr class="my-5">

<h3>Recent Placement Drives</h3>

<div class="row">

<?php

$companies = mysqli_query($conn,
"SELECT * FROM companies ORDER BY id DESC LIMIT 6");

if(mysqli_num_rows($companies)>0)
{
while($row=mysqli_fetch_assoc($companies))
{

?>

<div class="col-md-4 mb-4">

<div class="card shadow h-100">

<div class="card-body">

<h5>

<?php echo htmlspecialchars($row['company_name']); ?>

</h5>

<p>

Role :
<strong>

<?php echo htmlspecialchars($row['role']); ?>

</strong>

</p>

<p>

Package :
<strong>

<?php echo htmlspecialchars($row['package']); ?>

</strong>

</p>

<p>

Eligibility :

<?php echo htmlspecialchars($row['eligibility']); ?>

CGPA

</p>

<a href="apply.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
    Apply
</a>

</div>

</div>

</div>

<?php

}
}
else
{
echo "<p>No Placement Drives Available.</p>";
}

?>

</div>

</div>

</body>
</html>