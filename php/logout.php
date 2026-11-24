<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logout Confirmation</title>
  <script src="logout.js"></script>
  <style>
    #logout-confirmation {
      display: none;
      position: fixed;
      top: 30%;
      left: 50%;
      transform: translate(-50%, -30%);
      background-color: #fff;
      border: 2px solid #333;
      padding: 20px;
      z-index: 1000;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
      text-align: center;
    }

    #logout-confirmation button {
      margin: 10px;
      padding: 10px 20px;
      font-size: 16px;
    }

    #overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }
  </style>
</head>
<body>

  <!-- Logout Button -->
  <button onclick="confirmLogout()">Logout</button>

  <!-- Overlay -->
  <div id="overlay"></div>

  <!-- Confirmation Dialog -->
  <div id="logout-confirmation">
    <p>Are you sure you want to LOGOUT?</p>
    <button onclick="proceedLogout()">Yes</button>
    <button onclick="cancelLogout()">No</button>
  </div>

</body>
</html>