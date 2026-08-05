<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT
            applications.id,
            companies.company_name,
            companies.role,
            companies.package,
            applications.status,
            applications.applied_at
        FROM applications
        INNER JOIN companies
        ON applications.company_id = companies.id
        WHERE applications.student_id = '$student_id'
        ORDER BY applications.applied_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>

<title>My Applications</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2>My Applications</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">
Back to Dashboard
</a>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>#</th>
<th>Company</th>
<th>Role</th>
<th>Package</th>
<th>Applied On</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$count = 1;

if(mysqli_num_rows($result)>0)
{
while($row=mysqli_fetch_assoc($result))
{

?>

<tr>

<td><?php echo $count++; ?></td>

<td><?php echo htmlspecialchars($row['company_name']); ?></td>

<td><?php echo htmlspecialchars($row['role']); ?></td>

<td><?php echo htmlspecialchars($row['package']); ?></td>

<td><?php echo htmlspecialchars($row['applied_at']); ?></td>

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
elseif($row['status']=="Rejected")
{
    echo "<span class='badge bg-danger'>Rejected</span>";
}
else
{
    echo htmlspecialchars($row['status']);
}

?>

</td>

</tr>

<?php

}
}
else
{
echo "<tr>
<td colspan='6' class='text-center'>
No Applications Found
</td>
</tr>";
}

?>

</tbody>

</table>

</div>

</body>
</html>