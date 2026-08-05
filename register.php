<?php
include "config/db.php";

$message = "";

if(isset($_POST['register']))
{
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $phone = trim($_POST['phone']);
    $department = trim($_POST['department']);
    $cgpa = $_POST['cgpa'];

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM students WHERE email='$email'");

    if(mysqli_num_rows($check) > 0)
    {
        $message = "<div class='alert alert-danger'>Email already registered.</div>";
    }
    else
    {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO students(name,email,password,phone,department,cgpa)
                VALUES('$name','$email','$hashedPassword','$phone','$department','$cgpa')";

        if(mysqli_query($conn, $sql))
        {
            header("Location: login.php?success=1");
            exit();
        }
        else
        {
            $message = "<div class='alert alert-danger'>Registration Failed.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-primary text-white">
<h3 class="text-center">Student Registration</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Phone</label>
<input type="text" name="phone" class="form-control">
</div>

<div class="mb-3">
<label>Department</label>
<input type="text" name="department" class="form-control">
</div>

<div class="mb-3">
<label>CGPA</label>
<input type="number" step="0.01" name="cgpa" class="form-control">
</div>

<button type="submit" name="register" class="btn btn-success w-100">
Register
</button>

</form>

<br>

<div class="text-center">
Already have an account?
<a href="login.php">Login</a>
</div>

</div>

</div>

</div>

</div>

</div>

</body>
</html>