<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* Statistics */

$students = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM students"));

$companies = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM companies"));

$applications = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM applications"));

$selected = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM applications
WHERE status='Selected'"));

$pending = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM applications
WHERE status='Pending'"));

$rejected = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total
FROM applications
WHERE status='Rejected'"));
?>

<!DOCTYPE html>

<html>

<head>

<title>Placement Analytics</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">
Placement Analytics Dashboard
</h2>

<a href="dashboard.php"
class="btn btn-secondary mb-4">
Back
</a>

<div class="row">

<div class="col-md-4 mb-3">

<div class="card text-white bg-primary">

<div class="card-body">

<h5>Total Students</h5>

<h1>
<?php echo $students['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card text-white bg-success">

<div class="card-body">

<h5>Total Companies</h5>

<h1>
<?php echo $companies['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card text-white bg-dark">

<div class="card-body">

<h5>Total Applications</h5>

<h1>
<?php echo $applications['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card text-white bg-warning">

<div class="card-body">

<h5>Pending</h5>

<h1>
<?php echo $pending['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card text-white bg-danger">

<div class="card-body">

<h5>Rejected</h5>

<h1>
<?php echo $rejected['total']; ?>
</h1>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card text-white bg-info">

<div class="card-body">

<h5>Selected</h5>

<h1>
<?php echo $selected['total']; ?>
</h1>

</div>

</div>

</div>

</div>

<hr>

<h3>Application Status Chart</h3>

<canvas id="statusChart"></canvas>

</div>

<script>

const ctx = document.getElementById('statusChart');

new Chart(ctx, {

type: 'bar',

data: {

labels: ['Pending','Selected','Rejected'],

datasets: [{

label: 'Applications',

data: [

<?php echo $pending['total']; ?>,

<?php echo $selected['total']; ?>,

<?php echo $rejected['total']; ?>

],

borderWidth: 1

}]

},

options: {

responsive: true,

scales: {

y: {

beginAtZero: true

}

}

}

});

</script>

</body>
</html>