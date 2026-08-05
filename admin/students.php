<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$search="";

if(isset($_GET['search']))
{
    $search=mysqli_real_escape_string($conn,$_GET['search']);
}

$sql="SELECT *
FROM students
WHERE
name LIKE '%$search%'
OR email LIKE '%$search%'
ORDER BY id DESC";

$result=mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Registered Students</h2>

<a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>

<form method="GET" class="mb-4">

<div class="row">

<div class="col-md-6">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Student Name or Email"
value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

</div>

<div class="col-md-2">

<button class="btn btn-primary">

Search

</button>

</div>

<div class="col-md-2">

<a href="students.php"
class="btn btn-secondary">

Reset

</a>

</div>

</div>

</form>

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Resume</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td>

<?php
if (!empty($row['resume'])) {
?>

<a href="../uploads/resumes/<?php echo htmlspecialchars($row['resume']); ?>"
target="_blank"
class="btn btn-success btn-sm">

View Resume

</a>

<?php
} else {
    echo "Not Uploaded";
}
?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>
</html>