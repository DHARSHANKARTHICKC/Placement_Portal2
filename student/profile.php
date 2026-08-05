<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$result = mysqli_query($conn, "SELECT * FROM students WHERE id='$student_id'");
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>My Profile</h3>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="30%">Name</th>
<td><?php echo htmlspecialchars($student['name']); ?></td>
</tr>

<tr>
<th>Email</th>
<td><?php echo htmlspecialchars($student['email']); ?></td>
</tr>

<tr>
<th>Phone</th>
<td><?php echo htmlspecialchars($student['phone']); ?></td>
</tr>

<tr>
<th>Department</th>
<td><?php echo htmlspecialchars($student['department']); ?></td>
</tr>

<tr>
<th>CGPA</th>
<td><?php echo htmlspecialchars($student['cgpa']); ?></td>
</tr>

<tr>
<th>Resume</th>

<td>

<?php

if(!empty($student['resume']))
{
?>

<a
href="../uploads/resumes/<?php echo htmlspecialchars($student['resume']); ?>"
target="_blank"
class="btn btn-success btn-sm">

View Resume

</a>

<?php
}
else
{
echo "Resume Not Uploaded";
}

?>

</td>

</tr>

</table>

<a href="edit_profile.php" class="btn btn-primary">
Edit Profile
</a>

<a href="dashboard.php" class="btn btn-secondary">
Back
</a>

</div>

</div>

</div>

</body>
</html>