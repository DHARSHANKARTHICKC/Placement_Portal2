<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$company_id = (int)$_GET['id'];

// Check if already applied
$check = mysqli_query($conn,
"SELECT * FROM applications
WHERE student_id='$student_id'
AND company_id='$company_id'");

if(mysqli_num_rows($check) > 0)
{
    echo "<script>
    alert('You have already applied for this company.');
    window.location='companies.php';
    </script>";
    exit();
}

// Insert application
mysqli_query($conn,
"INSERT INTO applications(student_id, company_id)
VALUES('$student_id','$company_id')");

echo "<script>
alert('Application Submitted Successfully!');
window.location='companies.php';
</script>";
?>