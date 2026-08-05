<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

/* -----------------------------
   Update Application Status
------------------------------*/

if (isset($_GET['id']) && isset($_GET['status'])) {

    $id = (int)$_GET['id'];
    $newStatus = mysqli_real_escape_string($conn, $_GET['status']);

    mysqli_query($conn,
    "UPDATE applications
     SET status='$newStatus'
     WHERE id=$id");

    header("Location: applications.php");
    exit();
}

/* -----------------------------
   Search & Filter
------------------------------*/

$search = "";
$status = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
}

if (isset($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
}

$sql = "SELECT
applications.id,
applications.status,
students.name,
companies.company_name,
companies.role

FROM applications

INNER JOIN students
ON applications.student_id = students.id

INNER JOIN companies
ON applications.company_id = companies.id

WHERE
(
students.name LIKE '%$search%'
OR companies.company_name LIKE '%$search%'
)";

if ($status != "") {

    $sql .= " AND applications.status='$status'";

}

$sql .= " ORDER BY applications.id DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

<title>Applications</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Student Applications</h2>

<a href="dashboard.php"
class="btn btn-secondary mb-3">
Back
</a>

<form method="GET" class="row mb-4">

<div class="col-md-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Student or Company"
value="<?php echo htmlspecialchars($search); ?>">

</div>

<div class="col-md-3">

<select
name="status"
class="form-select">

<option value=""
<?php if($status=="") echo "selected"; ?>>

All Applications

</option>

<option value="Pending"
<?php if($status=="Pending") echo "selected"; ?>>

Pending

</option>

<option value="Selected"
<?php if($status=="Selected") echo "selected"; ?>>

Selected

</option>

<option value="Rejected"
<?php if($status=="Rejected") echo "selected"; ?>>

Rejected

</option>

</select>

</div>

<div class="col-md-2">

<button
class="btn btn-primary w-100">

Search

</button>

</div>

<div class="col-md-2">

<a
href="applications.php"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</form>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Student</th>

<th>Company</th>

<th>Role</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['name']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['company_name']); ?>

</td>

<td>

<?php echo htmlspecialchars($row['role']); ?>

</td>

<td>

<?php

if($row['status']=="Pending")
{
echo "<span class='badge bg-warning'>Pending</span>";
}

elseif($row['status']=="Selected")
{
echo "<span class='badge bg-success'>Selected</span>";
}

else
{
echo "<span class='badge bg-danger'>Rejected</span>";
}

?>

</td>

<td>

<a
href="?id=<?php echo $row['id']; ?>&status=Selected"
class="btn btn-success btn-sm">

Select

</a>

<a
href="?id=<?php echo $row['id']; ?>&status=Rejected"
class="btn btn-danger btn-sm">

Reject

</a>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="6" class="text-center">

No Applications Found

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</body>

</html>