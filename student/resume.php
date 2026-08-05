<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$message = "";

if(isset($_POST['upload']))
{
    if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0)
    {
        $fileName = time() . "_" . basename($_FILES['resume']['name']);
        $target = "../uploads/resumes/" . $fileName;

        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if($extension != "pdf")
        {
            $message = "<div class='alert alert-danger'>
                        Only PDF files are allowed.
                        </div>";
        }
        else
        {
            if(move_uploaded_file($_FILES['resume']['tmp_name'], $target))
            {
                mysqli_query($conn,
                "UPDATE students
                 SET resume='$fileName'
                 WHERE id='$student_id'");

                $message = "<div class='alert alert-success'>
                            Resume Uploaded Successfully.
                            </div>";
            }
            else
            {
                $message = "<div class='alert alert-danger'>
                            Upload Failed.
                            </div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Upload Resume</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Upload Resume</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label>Select Resume (PDF Only)</label>

<input
type="file"
name="resume"
accept=".pdf"
class="form-control"
required>

</div>

<button
class="btn btn-primary"
name="upload">

Upload Resume

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

</body>
</html>
