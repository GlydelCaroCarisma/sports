<?php
include 'conn.php';

$Uname = $_POST['xUname'];
$pass = $_POST['xpass'];

// Check if admin
$sqlAdmin = "SELECT * FROM tb_admin WHERE admin_id = ? AND passw = ?";
$stmtAdmin = $conn->prepare($sqlAdmin);
$stmtAdmin->bindParam(1, $Uname);
$stmtAdmin->bindParam(2, $pass);
$stmtAdmin->execute();
$admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

if ($admin) {
    echo  '<script>alert("Log in Successfuly"); window.location.href="../php/admindashboard.php";</script>';
    exit;
}

// Check if regular user
$sql = "SELECT * FROM tb_register WHERE Id = ? AND Passw = ?";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $Uname);
$stmt->bindParam(2, $pass);
$stmt->execute();

$user =$stmt->fetch((PDO::FETCH_ASSOC));


if ($user) {
    $_SESSION['user_id'] = $user['Id'];
    $_SESSION['user_name'] = $user['Fname']; // optional, if you want to display name
    $_SESSION['role'] = 'user';
    echo  '<script>alert("Log in Successfuly"); window.location.href="../php/userdashboard.php";</script>';
    exit;
}else{
    echo '<script>alert("User Not Found HAHAHA"); window.location.href="../html/login.html";</script>';
    exit;
}
?>

// include 'conn.php';

// $Uname = $_POST['xUname'];
// $pass = $_POST['xpass'];


// $sql = "SELECT * FROM tb_register WHERE Id = ? AND Passw = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(1, $Uname);
// $stmt->bindParam(2, $pass);
// $stmt->execute();

// $user =$stmt->fetch((PDO::FETCH_ASSOC));


// if ($user) {
//     echo  '<script>alert("Log in Successfuly"); window.location.href="../php/userdashboard.php";</script>';
    
// }else{
//     echo '<script>alert("User Not Found HAHAHA"); window.location.href="../html/login.html";</script>';
// }


// include 'admindashboard.php'
// $Uname = $_POST['xUname'];
// $pass = $_POST['xpass'];

// $sql = "SELECT * FROM tb_admin WHERE admin_id = ? AND passw = ?";
// $stmt = $conn->prepare($sql);
// $stmt->bindParam(1, $Uname);
// $stmt->bindParam(2, $pass);
// $stmt->execute();

// $user =$stmt->fetch((PDO::FETCH_ASSOC));
//  if ($user) {
//     echo '<script>alert("Welcome Admin!!"); window.location.href="../php/admindashboard.php";</script>'"Successfully Login";
// }else{
//     echo '<script>alert("Log in Failed"); window.location.href="../html/login.html";</script>';
// }
