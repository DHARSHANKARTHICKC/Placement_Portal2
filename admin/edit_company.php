<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = (int)$_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM companies WHERE id=$id");
$company = mysqli_fetch_assoc($result);

if (!$company) {
    die("Company not found.");
}

if(isset($_POST['update'])){

    $company_name = $_POST['company_name'];
    $role = $_POST['role'];
    $package = $_POST['package'];
    $eligibility = $_POST['eligibility'];
    $last_date = $_POST['last_date'];
    $description = $_POST['description'];

    mysqli_query($conn,"
    UPDATE companies SET
    company_name='$company_name',
    role='$role',
    package='$package',
    eligibility='$eligibility',
    last_date='$last_date',
    description='$description'
    WHERE id=$id
    ");

    header("Location: companies.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Company</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Edit Company</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">
<label>Company</label>
<input
type="text"
name="company_name"
class="form-control"
value="<?php echo htmlspecialchars($company['company_name']); ?>"
required>
</div>

<div class="mb-3">
<label>Role</label>
<input
type="text"
name="role"
class="form-control"
value="<?php echo htmlspecialchars($company['role']); ?>"
required>
</div>

<div class="mb-3">
<label>Package</label>
<input
type="text"
name="package"
class="form-control"
value="<?php echo htmlspecialchars($company['package']); ?>"
required>
</div>

<div class="mb-3">
<label>Minimum CGPA</label>
<input
type="number"
step="0.01"
name="eligibility"
class="form-control"
value="<?php echo htmlspecialchars($company['eligibility']); ?>"
required>
</div>

<div class="mb-3">
<label>Last Date</label>
<input
type="date"
name="last_date"
class="form-control"
value="<?php echo htmlspecialchars($company['last_date']); ?>"
required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea
name="description"
class="form-control"
rows="4"><?php echo htmlspecialchars($company['description']); ?></textarea>
</div>

<button class="btn btn-success" name="update">
Update Company
</button>

<a href="companies.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

</body>
</html>
