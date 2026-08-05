<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['add_company'])) {

    $company_name = trim($_POST['company_name']);
    $role = trim($_POST['role']);
    $package = trim($_POST['package']);
    $eligibility = $_POST['eligibility'];
    $last_date = $_POST['last_date'];
    $description = trim($_POST['description']);

    $sql = "INSERT INTO companies
            (company_name, role, package, eligibility, last_date, description)
            VALUES
            ('$company_name', '$role', '$package',
             '$eligibility', '$last_date', '$description')";

    if (mysqli_query($conn, $sql)) {

        $message = "<div class='alert alert-success'>
                    Company Added Successfully!
                    </div>";

    } else {

        $message = "<div class='alert alert-danger'>
                    Error Adding Company.
                    </div>";

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add Company</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Add Placement Drive</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Company Name</label>
<input type="text"
name="company_name"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Job Role</label>
<input type="text"
name="role"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Package</label>
<input type="text"
name="package"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Minimum CGPA</label>
<input type="number"
step="0.01"
name="eligibility"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Last Date</label>
<input type="date"
name="last_date"
class="form-control"
required>
</div>

<div class="mb-3">
<label>Description</label>
<textarea
name="description"
class="form-control"
rows="4"></textarea>
</div>

<button
class="btn btn-primary"
name="add_company">

Add Company

</button>

<a href="dashboard.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</body>

</html>