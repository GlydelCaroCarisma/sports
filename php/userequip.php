<?php
session_start();
include 'conn.php';

// Fetch all equipment added by any admin
$stmt = $conn->prepare("SELECT * FROM tb_equipment ORDER BY date_added DESC");
$stmt->execute();
$equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Available Equipment | Sports Equipment</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 30%, #ff6f00 60%, #ffcc00 100%);
      color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: rgba(0, 0, 0, 0.3);
      padding: 20px 5%;
      display: flex;
      justify-content: space-between;
      align-items: center;
      backdrop-filter: blur(10px);
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 600;
      color: #ffcc00;
    }

    nav {
      display: flex;
      gap: 20px;
    }

    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      padding: 10px 15px;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      transition: background 0.3s;
    }

    nav a:hover {
      background-color: #ffcc00;
      color: #2c3e50;
    }

    .container {
      padding: 60px 5%;
    }

    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #ffcc00;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }

    .grid-item {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 25px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      transition: transform 0.3s;
    }

    .grid-item:hover {
      transform: scale(1.05);
    }

    .grid-item img {
      width: 150px;
      height: auto;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .grid-item p {
      font-size: 1rem;
      color: #fff;
      opacity: 0.9;
      margin: 5px 0;
    }

    footer {
      background-color: rgba(0, 0, 0, 0.4);
      color: white;
      padding: 30px 5%;
      text-align: center;
      backdrop-filter: blur(10px);
      margin-top: 50px;
    }

    footer .social a {
      color: white;
      font-size: 1.5rem;
      margin: 0 10px;
      text-decoration: none;
      transition: color 0.3s;
    }

    footer .social a:hover {
      color: #ffcc00;
    }

    @media (max-width: 1024px) {
      .grid {
        grid-template-columns: repeat(3, 1fr);
      }
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
    <div class="logo">🏀 Sports Equipment</div>
    <nav>
      <a href="../php/userdashboard.php"><i class="fas fa-home"></i>Home</a>
      <a href="../php/userequip.php"><i class="fas fa-volleytball"></i>Equipment</a>
      <a href="return.html"><i class="fas fa-history"></i>Transactionst</a>
      <a href="profile.html"><i class="fas fa-user"></i>Profile</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </nav>
  </header>

  <div class="container">
    <h2>Available Equipment</h2>
    <div class="grid">
      <?php if (!empty($equipments)) { ?>
        <?php foreach ($equipments as $item) { ?>
          <div class="grid-item">
            <img src="<?= htmlspecialchars($item['filepath'] ?? 'default_equipment.jpg') ?>" alt="Equipment Image">
            <p><b><?= htmlspecialchars($item['name']) ?></b></p>
            <p>Category: <?= htmlspecialchars($item['category']) ?></p>
            <p>Brand: <?= htmlspecialchars($item['brand']) ?></p>
            <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
            <p>ID: <?= htmlspecialchars($item['equipment_id']) ?></p>
          </div>
        <?php } ?>
      <?php } else { ?>
        <p style="text-align:center;">No equipment available at the moment.</p>
      <?php } ?>
    </div>
  </div>

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