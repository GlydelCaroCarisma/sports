<?php
include 'conn.php';

$Id = $_POST['xId'];
$Fname = $_POST['xFname'];
$Mname = $_POST['xMname'];
$Lname = $_POST['xLname'];
$Gender = $_POST['xGender'];
$Course = $_POST['xCourse'];
$Year = $_POST['xYear'];
$Section = $_POST['xSection'];
$Email = $_POST['xEmail'];
$Password = $_POST['xPassword'];

$sql = "INSERT INTO tb_register(Id, Fname, Mname, Lname, Course, Gender, YearLvl, Section, Email, Passw) VALUES (?,?,?,?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $Id);
$stmt->bindParam(2, $Fname);
$stmt->bindParam(3, $Mname);
$stmt->bindParam(4, $Lname);
$stmt->bindParam(5, $Course);
$stmt->bindParam(6, $Gender);
$stmt->bindParam(7, $Year);
$stmt->bindParam(8, $Section);
$stmt->bindParam(9, $Email);
$stmt->bindParam(10, $Password);

if ($stmt->execute()) {
    echo '<script>alert("Registration Successful"); window.location.href="../html/login.html";</script>';
    exit;
}
?>