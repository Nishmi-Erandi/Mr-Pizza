<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <title>Admin Panel</title>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Roboto', sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
    }

    .side-bar {
      background-color: rgb(108, 51, 4);
      width: 250px;
      height: 100vh;
      padding-top: 2rem;
      position: fixed;
      top: 0;
      left: 0;
      overflow-y: auto;
      transition: transform 0.3s ease;
    }

    .side-bar h2 {
      color: #fff;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 2rem;
    }

    .content-menu ul {
      list-style: none;
      padding: 0;
      text-decoration: none;
    }

    .content-menu li {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1rem 2rem;
      color: white;
      font-size: 1.1rem;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    .content-menu li:hover {
      background-color: #ff7700;
    }

    .content-menu i {
      width: 20px;
    }

    /* Responsive Sidebar */
    @media (max-width: 768px) {
      .side-bar {
        width: 200px;
      }

      .content-menu li {
        font-size: 1rem;
        padding: 0.8rem 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .side-bar {
        transform: translateX(-100%);
        position: absolute;
        z-index: 1000;
      }

      .side-bar.active {
        transform: translateX(0);
      }

      .toggle-btn {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 1.5rem;
        color: white;
        background-color: #6c3304;
        border: none;
        padding: 10px;
        border-radius: 5px;
        z-index: 1001;
      }
    }
  </style>
</head>
<body>

  <!-- Mobile toggle button -->
  <button class="toggle-btn" onclick="toggleSidebar()">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Sidebar -->
  <div class="side-bar" id="sidebar">
    <h2>Admin Panel</h2>
    <div class="content-menu">
      <ul>
        <a href="dashboard.php"><li><i class="fa-solid fa-house"></i>Dashboard</li>
        <a href="display.php"><li><i class="fa-solid fa-cart-shopping"></i>Orders</li></a>
        <a href="adMenu.php"><li><i class="fa-solid fa-utensils"></i>Menu</li></a>
       
      </ul>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }
  </script>

</body>
</html>
