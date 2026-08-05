<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$message = "";

if(isset($_POST['update']))
{

$phone=$_POST['phone'];
$department=$_POST['department'];
$cgpa=$_POST['cgpa'];

$sql="UPDATE students
SET
phone='$phone',
department='$department',
cgpa='$cgpa'
WHERE id='$student_id'";

if(mysqli_query($conn,$sql))
{
$message="<div class='alert alert-success'>
Profile Updated Successfully
</div>";
}
else
{
$message="<div class='alert alert-danger'>
Update Failed
</div>";
}

}

$result=mysqli_query($conn,
"SELECT * FROM students WHERE id='$student_id'");

$student=mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Edit Profile</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Name</label>

<input
type="text"
class="form-control"
value="<?php echo htmlspecialchars($student['name']); ?>"
readonly>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
class="form-control"
value="<?php echo htmlspecialchars($student['email']); ?>"
readonly>

</div>

<div class="mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo htmlspecialchars($student['phone']); ?>">

</div>

<div class="mb-3">

<label>Department</label>

<input
type="text"
name="department"
class="form-control"
value="<?php echo htmlspecialchars($student['department']); ?>">

</div>

<div class="mb-3">

<label>CGPA</label>

<input
type="number"
step="0.01"
name="cgpa"
class="form-control"
value="<?php echo htmlspecialchars($student['cgpa']); ?>">

</div>

<button
class="btn btn-success"
name="update">

Update Profile

</button>

<a
href="profile.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</body>
</html>