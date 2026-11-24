<?php
session_start();
include 'conn.php';

// Ensure admin is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Handle equipment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = $_POST['equipment_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $date_added = date('Y-m-d');

    // Handle image upload
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = 'uploads/';
        $targetPath = $targetDir . time() . '_' . $imageName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = $targetPath;
        }
    }

    $stmt = $conn->prepare("INSERT INTO tb_equipment (equipment_id, name, category, brand, quantity, description, date_added, added_by, filepath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$equipment_id, $name, $category, $brand, $quantity, $description, $date_added, $_SESSION['user'], $imagePath]);

    echo "<script>alert('Equipment added successfully!'); window.location.href='equipment.php';</script>";
    exit();
}

// Fetch equipment added by this admin
$stmt = $conn->prepare("SELECT * FROM tb_equipment WHERE added_by = ?");
$stmt->execute([$_SESSION['user']]);
$equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Equipment Dashboard | Sports Equipment</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 30%, #ff6f00 60%, #ffcc00 100%);
      color: #fff;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
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
      display: flex;
      align-items: center;
      transition: background 0.3s;
      background: rgba(255, 255, 255, 0.1);
    }

    nav a i {
      margin-right: 8px;
    }

    nav a:hover {
      background-color: #ffcc00;
      color: #2c3e50;
    }

    .container {
      flex: 1;
      padding: 60px 5%;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* Fixed to 4 columns */
      gap: 30px;
    }

    .grid-item {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
      transition: transform 0.3s;
    }

    .grid-item:hover {
      transform: scale(1.05);
    }

    .grid-item img {
      width: 100%;
      max-height: 200px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .grid-item p {
      font-size: 1rem;
      color: #fff;
      opacity: 0.9;
    }

    .add-button {
      text-align: center;
      margin: 40px 0;
    }

    .add-button button {
      background: linear-gradient(135deg, #ff6f00, #ffcc00);
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      transition: transform 0.2s, background 0.3s;
    }

    .add-button button:hover {
      transform: scale(1.05);
      background: linear-gradient(135deg, #ffcc00, #ff6f00);
    }

    #equipmentModal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.6);
    }

    .modal-content {
      background: rgba(255, 255, 255, 0.95);
      margin: 5% auto;
      padding: 30px;
      border-radius: 15px;
      width: 90%;
      max-width: 500px;
      color: #333;
      box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .modal-content h2 {
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .modal-content label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
    }

    .modal-content input,
    .modal-content select,
    .modal-content textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 1rem;
    }

    .modal-content button {
      margin-top: 20px;
      background: linear-gradient(135deg, #ff6f00, #ffcc00);
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 1rem;
      font-weight: 600;
      transition: background 0.3s;
    }

    .modal-content button:hover {
      background: linear-gradient(135deg, #ffcc00, #ff6f00);
    }

    .modal-content span {
      float: right;
      font-size: 1.5rem;
      font-weight: bold;
      cursor: pointer;
      color: #ff6f00;
    }

    footer {
      background-color: rgba(0, 0, 0, 0.4);
      color: white;
      padding: 30px 5%;
      text-align: center;
      backdrop-filter: blur(10px);
    }

    footer p {
      margin-bottom: 10px;
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

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
      }

      nav {
        flex-direction: column;
        gap: 15px;
      }

      .grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 576px) {
      .grid {
        grid-template-columns: 1fr;
      }
    }

  </style>
  <script>
    window.onclick = function(event) {
      const modal = document.getElementById('equipmentModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    const itemsByCategory = {
    "Ball Sports": ["Basketball", "Football", "Volleyball", "Softball"],
    "Racquet Sports": ["Tennis Racket", "Badminton Racket", "Table Tennis Paddle"],
    "Track & Field": ["Relay Baton", "Shot Put", "Javelin", "Hurdles"],
    "Martial Arts": ["Boxing Gloves", "Karate Pads", "Headgear"],
    "Aquatic Sports": ["Swim Goggles", "Kickboard", "Snorkel"],
    "Fitness & Conditioning": ["Dumbbells", "Resistance Bands", "Yoga Mat"],
    "Adventure & Outdoor": ["Tent", "Compass", "Backpack"],
    "Rolling Sports": ["Skateboard", "Rollerblades", "Scooter"],
    "Safety Gear": ["Helmet", "Knee Pads", "Elbow Pads"]
  };

  function updateItems() {
    const category = document.getElementById("category").value;
    const itemSelect = document.getElementById("itemName");

    // Clear previous options
    itemSelect.innerHTML = '<option value="" disabled selected>Select an item</option>';

    // Populate new options
    if (itemsByCategory[category]) {
      itemsByCategory[category].forEach(item => {
        const option = document.createElement("option");
        option.value = item;
        option.textContent = item;
        itemSelect.appendChild(option);
      });
    }
  }
  </script>
</head>
<body>

  <header>
    <div class="logo">Admin Dashboard</div>
    <nav>
      <a href="admindashboard.php"><i class="fas fa-home"></i>Home</a>
      <a href="equipment.php"><i class="fas fa-basketball"></i>Equipment</a>
      <a href="#"><i class="fas fa-check"></i>Requests</a>
      <a href="#"><i class="fas fa-users"></i>User</a>
      <a href="#"><i class="fas fa-history"></i>Transactions</a>
      <a href="index.html"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </nav>
  </header>

  <div class="container">
    <div class="grid">
      <div class="grid-item">
        <h3>Total Equipment</h3>
        <p><?= count($equipments) ?> Item/s</p>
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
        <p>3 Item/s</p>
      </div>
    </div>

    <div class="add-button">
      <button onclick="document.getElementById('equipmentModal').style.display='block'">+ Add Equipment</button>
    </div>

    <div id="equipmentModal">
      <div class="modal-content">
        <span onclick="document.getElementById('equipmentModal').style.display='none'">&times;</span>
        <h2>Add Equipment</h2>
        <form method="POST" enctype="multipart/form-data">
          <label>Unique ID</label>
          <input type="text" name="equipment_id" required>

          <label>Category</label>
          <select name="category" id="category" required onchange="updateItems()">
            <option value="" disabled selected>Select a category</option>
            <option value="Ball Sports">Ball Sports</option>
            <option value="Racquet Sports">Racquet Sports</option>
            <option value="Track & Field">Track & Field</option>
            <option value="Martial Arts">Martial Arts</option>
            <option value="Aquatic Sports">Aquatic Sports</option>
            <option value="Fitness & Conditioning">Fitness & Conditioning</option>
            <option value="Adventure & Outdoor">Adventure & Outdoor</option>
            <option value="Rolling Sports">Rolling Sports</option>
            <option value="Safety Gear">Safety Gear</option>
          </select>

          <label>Item Name</label>
          <select name="name" id="itemName" required>
            <option value="" disabled selected>Select an item</option>
          </select>

          <label>Model/Brand</label>
          <input type="text" name="brand" required>

          <label>Quantity</label>
          <input type="number" name="quantity" required>

          <label>Description</label>
          <textarea name="description" rows="4" placeholder="Type here..."></textarea>

          <label>Upload Image</label>
          <input type="file" name="image" accept="image/*" required>

          <button type="submit">Add Equipment</button>
        </form>
      </div>
    </div>

    <h2 style="text-align:center; margin-bottom:20px;">Equipment Added by You</h2>
    <div class="grid">
      <?php if (!empty($equipments)) { ?>
        <?php foreach ($equipments as $item) { ?>
          <div class="grid-item">
            <img src="<?= htmlspecialchars($item['filepath'] ?? 'default_equipment.jpg') ?>" alt="Equipment Image" style="width:150px; height:auto; border-radius:10px; margin-bottom:10px;">
            <p><b>Item Name:</b> <br> <?= htmlspecialchars($item['name']) ?></p>
            <p><b>Quantity:</b> <?= htmlspecialchars($item['quantity']) ?></p>
            <div class="info">
              <p><b>Category:</b> <?= htmlspecialchars($item['category']) ?></p>
              <p><b>Brand:</b> <?= htmlspecialchars($item['brand']) ?></p>
              <p><b>Unique ID:</b> <?= htmlspecialchars($item['equipment_id']) ?></p>
              <p><b>Date Added:</b> <?= htmlspecialchars($item['date_added']) ?></p>
              <p><b>Description:</b> <br> <?= htmlspecialchars($item['description'] ?? '—') ?></p>
            </div>

            <!-- Action Buttons -->
            <div style="margin-top:15px;">
              <a href="edit_equipment.php?id=<?= urlencode($item['equipment_id']) ?>" style="padding:8px 15px; background:#28a745; color:#fff; border-radius:6px; text-decoration:none; margin-right:10px;">Edit</a>
              <a href="delete_equipment.php?id=<?= urlencode($item['equipment_id']) ?>" onclick="return confirm('Are you sure you want to delete this item?');" style="padding:8px 15px; background:#dc3545; color:#fff; border-radius:6px; text-decoration:none;">Delete</a>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <p style="text-align:center;">No equipment added yet.</p>
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
<script>
  document.querySelectorAll('.grid-item img').forEach(img => {
    img.addEventListener('click', function () {
      const item = this.closest('.grid-item');
      item.classList.toggle('active');
    });
  });
</script>
</body>
</html>
