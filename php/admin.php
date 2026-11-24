<?php
session_start();

include 'conn.php';

$Uname = $_POST['xUname'];
$pass = $_POST['xpass'];

$stmt = $conn->prepare("SELECT * FROM tb_admin WHERE admin_id=? AND passw=? AND role='admin'");
$stmt->bindParam(1, $Uname);
$stmt->bindParam(2, $pass);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION['admin_id'] = $user['admin_id'];
    echo "admin found";
} else {
    echo "admin not found";
}

?>