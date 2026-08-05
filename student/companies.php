<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$search = "";
$package = 0;

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if (isset($_GET['package']) && $_GET['package'] != "") {
    $package = (float)$_GET['package'];
}

$sql = "SELECT *
        FROM companies
        WHERE
        (company_name LIKE '%$search%'
        OR role LIKE '%$search%')
        AND package >= $package
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>Available Companies</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Available Placement Drives</h2>

<form method="GET" class="row mb-4">

<div class="col-md-4">
<input
type="text"
name="search"
class="form-control"
placeholder="Company / Role"
value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
</div>

<div class="col-md-3">
<input
type="number"
step="0.1"
name="package"
class="form-control"
placeholder="Minimum Package"
value="<?php echo isset($_GET['package']) ? htmlspecialchars($_GET['package']) : ''; ?>">
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">
Search
</button>
</div>

<div class="col-md-2">
<a href="companies.php" class="btn btn-secondary w-100">
Reset
</a>
</div>

</form>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Company</th>
<th>Role</th>
<th>Package</th>
<th>CGPA</th>
<th>Last Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo htmlspecialchars($row['company_name']); ?></td>

<td><?php echo htmlspecialchars($row['role']); ?></td>

<td><?php echo htmlspecialchars($row['package']); ?></td>

<td><?php echo htmlspecialchars($row['eligibility']); ?></td>

<td><?php echo htmlspecialchars($row['last_date']); ?></td>

<td>

<a
href="apply.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">

Apply

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>