<?php
session_start();
include 'conn.php';

$stmt = $conn->prepare("SELECT Id FROM tb_register WHERE Id=?");
$stmt->bindParam(1, $_SESSION['user']);
$stmt->execute();

$count = $stmt->rowCount();
$data = $stmt->fetchAll();

foreach ($data as $user) {
    // $user['Id'] if needed
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Sports Equipment</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f4f4f9;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    header {
      background-color: #6ab9cf;
      padding: 20px 5%;
      color: black;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 600;
    }

    nav {
      display: flex;
      gap: 20px;
    }

    nav a {
      color: #373b7a;
      text-decoration: none;
      font-weight: 500;
      padding: 10px 15px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      transition: background 0.3s;
    }

    nav a i {
      margin-right: 8px;
    }

    nav a:hover {
      background-color: #34495e;
      color: #4ebeca;
    }

    .container {
      flex: 1;
      padding: 50px 5%;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
      text-align: center;
    }

    .grid-item {
      background-color: rgba(205, 201, 201, 0.859);
      padding: 40px;
      border-radius: 12px;
      transition: transform 0.3s;
    }

    .grid-item:hover {
      transform: translateY(-5px);
    }

    .grid-item h3 {
      font-size: 2rem;
      margin-bottom: 15px;
    }

    .grid-item p {
      font-size: 1.3rem;
      color: #444;
    }

    .introduction-section {
      background-color: #ecf0f1;
      color: #2c3e50;
      padding: 60px 5%;
      text-align: center;
    }

    .introduction-section h2 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .introduction-section p {
      font-size: 1.3rem;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
    }

    footer {
      background-color: #2c3e50;
      color: white;
      padding: 30px 5%;
      text-align: center;
      margin-top: auto;
    }

    footer p {
      margin-bottom: 10px;
    }

    footer .social {
      margin-top: 10px;
    }

    footer .social a {
      color: white;
      font-size: 1.5rem;
      margin: 0 10px;
      text-decoration: none;
    }

    footer .social a:hover {
      color: #3498db;
    }

    @media (max-width: 768px) {
      .grid {
        grid-template-columns: repeat(2, 1fr);
      }

      header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }

      nav {
        flex-direction: column;
        gap: 15px;
      }
    }

    @media (max-width: 576px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">Admin Dashboard</div>
    <nav>
      <a href="#"><i class="fas fa-home"></i>Home</a>
      <a href="#"><i class="fas fa-basketball"></i>Equipment</a>
      <a href="#"><i class="fas fa-check"></i>Requests</a>
      <a href="#"><i class="fas fa-users"></i>User</a>
      <a href="#"><i class="fas fa-history"></i>Transactions</a>
      <a href="#"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </nav>
  </header>

  <div class="container">
    <div class="grid">
      <div class="grid-item">
        <h3>Total Equipment</h3>
        <p>120 Item/s</p>
      </div>
      <div class="grid-item">
        <h3>Active Users</h3>
        <p>85 Student/s</p>
      </div>
      <div class="grid-item">
        <h3>Borrow Requests</h3>
        <p>5 Request/s</p>
      </div>
      <div class="grid-item">
        <h3>Overdue Items</h3>
        <p>3 Item/s</p>
      </div>
    </div>
  </div>

  <section class="introduction-section">
    <h2>Admin Overview</h2>
    <p>This dashboard gives you a quick snapshot of system activity. Monitor equipment inventory, track active users, review pending borrow requests, and stay on top of overdue returns—all in one place.</p>
  </section>

  <footer>
    <p>&copy; 2025 Sports Equipment Borrowing System. All Rights Reserved.</p>
    <div class="social">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </footer>

</body>
</html>