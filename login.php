<?php
session_start();
include "config/db.php";

$message = "";

// Show registration success message
if (isset($_GET['success'])) {
    $message = "<div class='alert alert-success'>Registration Successful! Please login.</div>";
}

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Search for user by email
    $sql = "SELECT * FROM students WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $student = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $student['password'])) {

            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['name'];

            header("Location: student/dashboard.php");
            exit();

        } else {

            $message = "<div class='alert alert-danger'>Incorrect Password!</div>";

        }

    } else {

        $message = "<div class='alert alert-danger'>Email not found!</div>";

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Student Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3 class="text-center">Student Login</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
type="submit"
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

<hr>

<div class="text-center">

Don't have an account?

<a href="register.php">

Register

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>