<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Delete company
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM companies WHERE id=$id");

    header("Location: companies.php");
    exit();
}

$search="";

if(isset($_GET['search']))
{
    $search=mysqli_real_escape_string($conn,$_GET['search']);
}

$sql="SELECT *
FROM companies
WHERE
company_name LIKE '%$search%'
OR role LIKE '%$search%'
ORDER BY id DESC";

$result=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Companies</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">Manage Companies</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">
← Back to Dashboard
</a>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>
<th>ID</th>
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

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['company_name']); ?></td>

<td><?php echo htmlspecialchars($row['role']); ?></td>

<td><?php echo htmlspecialchars($row['package']); ?></td>

<td><?php echo htmlspecialchars($row['eligibility']); ?></td>

<td><?php echo htmlspecialchars($row['last_date']); ?></td>

<td>

<a
href="edit_company.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="companies.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this company?');">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>
</html>