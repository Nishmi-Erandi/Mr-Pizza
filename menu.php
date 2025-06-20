<?php include 'nav.php'; ?>
<?php
include("db.php");

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
    $title = $_POST['food_name'];
    $price = $_POST['food_price'];
    $image = $_POST['food_image'];
    $quantity = 1;
    $total = $price * $quantity;

    $check_cart = "SELECT * FROM cart WHERE title='$title'";
    $check_result = mysqli_query($con, $check_cart);

    if (mysqli_num_rows($check_result) > 0) {
        $update = "UPDATE cart SET quantity = quantity + 1, total = price * (quantity + 1) WHERE title='$title'";
        mysqli_query($con, $update);
    } else {
        $insert = "INSERT INTO cart (title, price, quantity, total, image) 
                   VALUES ('$title', '$price', '$quantity', '$total', '$image')";
        mysqli_query($con, $insert);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu</title>
  <style>
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    body { background-color: #FBFBFB; }

    .food_items {
      background-image: url(images/menu-banner.jpg);
      height: 40vh;
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      padding: 5rem;
      margin-top: 1rem;
    }

    /* Filter Buttons */
    .container .filter {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 1rem;
      padding: 1.5rem;
    }

    .container .filter .filter-item {
      padding: 0.6rem 1.8rem;
      border: 2px solid #ff7b00;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1rem;
      color: #333;
      background-color: #fff;
      cursor: pointer;
      transition: all 0.3s ease-in-out;
    }

    .container .filter .filter-item:hover {
      background-color: #ffe2c1;
      color: #b34c00;
      transform: scale(1.05);
    }

    .filter-item-active {
      background-color: #ff7b00 !important;
      color: #fff!important ;
      border-color: #ff7b00 !important;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      padding: 0 2rem 2rem 2rem;
    }

    .box {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      padding: 1rem;
      text-align: center;
      transition: transform 0.2s;
    }

    .box:hover { transform: scale(1.03); }

    .box img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 1rem;
    }

    .box h3 {
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
      color: green;
    }

    .price {
      font-size: 1rem;
      color: #e74c3c;
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .description {
      font-size: 0.95rem;
      color: rgba(14, 13, 13, 0.9);
      margin-bottom: 1rem;
    }

    .btn {
      padding: 0.5rem 1rem;
      border: none;
      background-color: rgb(230, 144, 15);
      color: white;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: rgb(240, 177, 29);
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      .food_items {
        height: 25vh;
        padding: 2rem;
      }

      .container .filter .filter-item {
        font-size: 0.9rem;
        padding: 0.5rem 1.2rem;
      }

      .box-container {
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        padding: 0 1rem 1rem 1rem;
      }

      .box {
        padding: 0.8rem;
      }

      .box img {
        height: 150px;
      }

      .box h3 {
        font-size: 1rem;
      }

      .price {
        font-size: 0.9rem;
      }

      .description {
        font-size: 0.85rem;
      }

      .btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      .container .filter {
        gap: 0.5rem;
        padding: 1rem;
      }

      .container .filter .filter-item {
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
      }

      .box-container {
        grid-template-columns: 1fr;
        padding: 0 0.5rem 1rem 0.5rem;
      }

      .box img {
        height: 120px;
      }

      .box h3 {
        font-size: 0.95rem;
      }

      .price {
        font-size: 0.85rem;
      }

      .description {
        font-size: 0.8rem;
      }

      .btn {
        width: 100%;
        padding: 0.5rem;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <section class="food_items"></section>

  <!-- Filters -->
  <div class="filter">
    <span class="filter-item filter-item-active" data-category="All">All</span>
    <span class="filter-item" data-category="pizza">Pizza</span>
    <span class="filter-item" data-category="burger">Burger</span>
    <span class="filter-item" data-category="other">Other</span>
  </div>

  <!-- Menu Items -->
  <div class="box-container" id="menu-items">
    <?php
    $select_item = "SELECT * FROM menuitems;";
    $result = mysqli_query($con, $select_item);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = htmlspecialchars($row['name']);
            $price = htmlspecialchars($row['price']);
            $desc = htmlspecialchars($row['description']);
            $img = htmlspecialchars($row['image']);
            $cat = htmlspecialchars($row['category']);
    ?>
    <form action="" method="POST" class="menu-item" data-category="<?= $cat ?>">
      <div class="box">
        <img src="uploads/<?php echo $img; ?>" alt="<?php echo $name; ?>">
        <h3><?php echo $name; ?></h3>
        <div class="description"><?php echo $desc; ?></div>
        <div class="price">Rs.<?php echo $price; ?></div>
        <input type="hidden" name="food_name" value="<?php echo $name; ?>">
        <input type="hidden" name="food_price" value="<?php echo $price; ?>">
        <input type="hidden" name="food_image" value="<?php echo $img; ?>">
        <input type="submit" class="btn" value="Add To Cart" name="add_to_cart">
      </div>
    </form>
    <?php
        }
    }
    ?>
  </div>
</div>

<!-- JavaScript for Filtering -->
<script>
  const filterItems = document.querySelectorAll('.filter-item');
  const menuItems = document.querySelectorAll('.menu-item');

  filterItems.forEach(btn => {
    btn.addEventListener('click', () => {
      filterItems.forEach(b => b.classList.remove('filter-item-active'));
      btn.classList.add('filter-item-active');

      const category = btn.dataset.category;

      menuItems.forEach(item => {
        const itemCategory = item.dataset.category;
        if (category === "All" || itemCategory === category) {
          item.style.display = "block";
        } else {
          item.style.display = "none";
        }
      });
    });
  });
</script>

</body>
</html>

<?php include 'footer.php'; ?>
