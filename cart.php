<?php 
include 'nav.php';
session_start();
include("db.php");

// Handle Quantity Update

if (isset($_POST['update_cart'])) {
    $orderID = intval($_POST['orderID']);
    $new_quantity = intval($_POST['quantity']);
    if ($new_quantity > 0) {
        $update_query = "UPDATE cart SET quantity = $new_quantity, total = price * $new_quantity WHERE orderID = $orderID";
        mysqli_query($con, $update_query);
    }
    header("Location: cart.php");
    exit();
}

// Handle Remove Item
if (isset($_POST['remove_item'])) {
    $orderID = intval($_POST['orderID']);
    $delete_query = "DELETE FROM cart WHERE orderID = $orderID";
    mysqli_query($con, $delete_query);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cart</title>
    <style>
     body {
  background-color: #f9f9f9;
  font-family: Arial, sans-serif;
  color: #333;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 1100px;
  margin: 2rem auto;
  background: #fff;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  padding: 2rem;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 1rem;
}

thead th {
  background-color: #f2f2f2;
  padding: 1rem 0.75rem;
  font-weight: 600;
  text-align: left;
  border-bottom: 2px solid #ddd;
}

tbody tr:hover {
  background-color: #fff7e6;
}

tbody td {
  padding: 1rem 0.75rem;
  vertical-align: middle;
  border-bottom: 1px solid #eee;
}

tbody img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

input[type=number] {
  width: 60px;
  padding: 0.3rem;
  border: 1.5px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

input[type=number]:focus {
  outline: none;
  border-color: #e67e22;
  box-shadow: 0 0 5px #e67e22;
}

button.btn-update,
button.btn-remove {
  padding: 0.45rem 1rem;
  font-size: 0.9rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  color: #fff;
  transition: background-color 0.3s ease;
}

button.btn-update {
  background-color: #e67e22;
}

button.btn-update:hover {
  background-color: #cf6a14;
}

button.btn-remove {
  background-color: #c0392b;
}

button.btn-remove:hover {
  background-color: #992d22;
}
.cart_total {
  display: flex;
  align-items: center;    /* vertically center text and image */
  justify-content: flex-start;  /* left align everything */
  gap: 10px;              /* small gap between text and image */
  padding: 1.5rem 2rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0,0,0,0.1);
  max-width: 1100px;
  margin: 2rem auto;
}

.cart_total .total {
  font-size: 1.3rem;
  
  margin-right: 10rem; 
}

.cart_total img {
  width: 200px;
  height: auto;
  margin: 0;  /* no margin */
}


.cart_total .checkout-btn {
  display: inline-block;
  margin-top: 1.5rem;
  background-color: #e67e22;
  border: none;
  padding: 1rem 2rem;
  border-radius: 25px;
  font-size: 1.1rem;
  color: white;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.cart_total .checkout-btn:hover {
  background-color: #cf6a14;
}

@media (max-width: 768px) {
  .cart_total {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .cart_total img {
    margin-top: 1rem;
  }

  .cart_total .checkout-btn {
    width: 100%;
  }
}

    </style>
</head>
<body>
    <div class="container">
        <div class="table">
            <table>
                <thead>
                   <th>Items</th>
                   <th>Title</th>
                   <th>Price</th>
                   <th>Quantity</th>
                   <th>Total</th>
                   <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $select_cart = "SELECT * FROM cart;";
                    $result = mysqli_query($con, $select_cart);
                    $check_result = mysqli_num_rows($result);

                    $subtotal = 0;

                    if ($check_result > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $subtotal += $row['total'];
                    ?>
                        <tr>
                            <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="100" alt="<?php echo htmlspecialchars($row['title']); ?>"></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>Rs.<?php echo htmlspecialchars($row['price']); ?></td>
                            <td>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="orderID" value="<?php echo intval($row['orderID']); ?>">
                                    <input type="number" min="1" name="quantity" value="<?php echo intval($row['quantity']); ?>">
                                    <button type="submit" name="update_cart" class="btn-update">Update</button>
                                </form>
                            </td>
                            <td>Rs.<?php echo htmlspecialchars($row['total']); ?></td>
                            <td>
                                <form method="POST" action="cart.php" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                    <input type="hidden" name="orderID" value="<?php echo intval($row['orderID']); ?>">
                                    <button type="submit" name="remove_item" class="btn-remove">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>Your cart is empty</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="cart_total">
        <div class="total">
            <h2>Cart Total</h2>
            <table>
            <tr>
                <td><h4>Sub Total</h4></td>
                <td>Rs.<?php echo $subtotal; ?></td>
            </tr>
            <tr>
                <td><h4>Delivery Fee</h4></td>
                <td>Rs.300</td>
            </tr>
            <tr>
                <td><h4>Total</h4></td>
                <td>Rs.<?php echo $subtotal + 300; ?></td>
            </tr>
            </table>
            <a href="detail.php" class="checkout-btn">Proceed to checkout</a>

        </div>
        <img src="images/sales.gif" alt="Delivery bike">
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
