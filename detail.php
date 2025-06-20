<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'nav.php';
include 'db.php';

$orderPlaced = false;
$errors = [];
$fullname = '';
$email = '';
$address = '';
$phone = '';

// Check if user is logged in (add user session check if needed)
// $user_id = $_SESSION['user_id'] ?? 1; // Default to 1 for testing

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    // Validate required fields
    if (empty($fullname)) {
        $errors[] = "Full name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($address)) {
        $errors[] = "Shipping address is required";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (!preg_match("/^[0-9+\-\s]{10,15}$/", $phone)) {
        $errors[] = "Invalid phone number format";
    }

    // Check if cart is empty
    $cartCheckQuery = "SELECT COUNT(*) as cart_count FROM cart";
    $cartResult = mysqli_query($con, $cartCheckQuery);
    
    if (!$cartResult) {
        $errors[] = "Database error: " . mysqli_error($con);
    } else {
        $cartData = mysqli_fetch_assoc($cartResult);
        if ($cartData['cart_count'] == 0) {
            $errors[] = "Your cart is empty";
        }
    }

    // If no errors, process the order
    if (empty($errors)) {
        // Start transaction
        mysqli_autocommit($con, FALSE);
        
        try {
            // Insert customer data
            $insertCustomerQuery = "INSERT INTO customers (fname, email, shipping_address, phone_num, order_date) VALUES (?, ?, ?, ?, NOW())";
            $customerStmt = mysqli_prepare($con, $insertCustomerQuery);
            
            if (!$customerStmt) {
                throw new Exception("Customer prepare failed: " . mysqli_error($con));
            }
            
            mysqli_stmt_bind_param($customerStmt, "ssss", $fullname, $email, $address, $phone);
            
            if (!mysqli_stmt_execute($customerStmt)) {
                throw new Exception("Customer insert failed: " . mysqli_stmt_error($customerStmt));
            }
            
            // Get the customer ID
            $customer_id = mysqli_insert_id($con);
            
            if (!$customer_id) {
                throw new Exception("Failed to get customer ID");
            }
            
            // Get all cart items
            $cartQuery = "SELECT * FROM cart";
            $cartResult = mysqli_query($con, $cartQuery);
            
            if (!$cartResult) {
                throw new Exception("Cart query failed: " . mysqli_error($con));
            }
            
            // Calculate totals
            $subtotal = 0;
            $delivery_fee = 300;
            $orderCount = 0;
            
            // Insert each cart item as an order
            while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                $item_total = floatval($cartItem['total']);
                $subtotal += $item_total;
                
                // Calculate grand total for this specific item
                $grand_total = $subtotal + $delivery_fee;
                
                $insertOrderQuery = "INSERT INTO orderss (customer_id, customer_name, customer_email, customer_phone, customer_address, 
                                    product_title, product_image, product_price, quantity, item_total, delivery_fee, 
                                    grand_total, order_date, order_status) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')";
                
                $orderStmt = mysqli_prepare($con, $insertOrderQuery);
                
                if (!$orderStmt) {
                    throw new Exception("Order prepare failed: " . mysqli_error($con));
                }
                
                // Prepare variables for binding (mysqli_stmt_bind_param requires variables, not expressions)
                $product_price = floatval($cartItem['price']);
                $product_quantity = intval($cartItem['quantity']);
                
                mysqli_stmt_bind_param($orderStmt, "issssssdiddd", 
                    $customer_id, 
                    $fullname, 
                    $email, 
                    $phone, 
                    $address,
                    $cartItem['title'], 
                    $cartItem['image'], 
                    $product_price, 
                    $product_quantity, 
                    $item_total, 
                    $delivery_fee, 
                    $grand_total
                );
                
                if (!mysqli_stmt_execute($orderStmt)) {
                    throw new Exception("Order insert failed: " . mysqli_stmt_error($orderStmt));
                }
                
                mysqli_stmt_close($orderStmt);
                $orderCount++;
            }
            
            if ($orderCount == 0) {
                throw new Exception("No items found in cart");
            }
            
            // Clear the cart after successful order placement
            $clearCartQuery = "DELETE FROM cart";
            if (!mysqli_query($con, $clearCartQuery)) {
                throw new Exception("Failed to clear cart: " . mysqli_error($con));
            }
            
            // Commit transaction
            mysqli_commit($con);
            mysqli_stmt_close($customerStmt);
            
            $orderPlaced = true;
            
            // Clear form variables
            $fullname = $email = $address = $phone = '';
            
        } catch (Exception $e) {
            // Rollback transaction on error
            mysqli_rollback($con);
            $errors[] = "Order placement failed: " . $e->getMessage();
        }
        
        // Re-enable autocommit
        mysqli_autocommit($con, TRUE);
    }
}

// Get cart items and total for display
$cartItemsQuery = "SELECT * FROM cart";
$cartItemsResult = mysqli_query($con, $cartItemsQuery);
$cartItems = [];
$cartSubtotal = 0;

if ($cartItemsResult) {
    while ($item = mysqli_fetch_assoc($cartItemsResult)) {
        $cartItems[] = $item;
        $cartSubtotal += floatval($item['total']);
    }
}

$deliveryFee = 300;
$grandTotal = $cartSubtotal + $deliveryFee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Checkout Details</title>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
    }

    .main-container {
      display: flex;
      min-height: 100vh;
      flex-wrap: wrap;
    }

    .image-section {
      flex: 1;
      min-width: 300px;
      background-color: #f2f2f2;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .image-section img {
      width: 100%;
      height: 100vh;
      object-fit: cover;
    }

    .form-section {
      flex: 1;
      min-width: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #fff;
      padding: 2rem;
    }

    .form-container {
      width: 100%;
      max-width: 500px;
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .order-summary {
      background: #f8f9fa;
      padding: 1.5rem;
      border-radius: 8px;
      margin-bottom: 2rem;
      border-left: 4px solid #e67e22;
    }

    .order-summary h3 {
      color: #e67e22;
      margin-bottom: 1rem;
    }

    .order-summary table {
      width: 100%;
      border-collapse: collapse;
    }

    .order-summary td {
      padding: 0.5rem 0;
      border-bottom: 1px solid #eee;
    }

    .order-summary .total-row {
      font-weight: bold;
      font-size: 1.1rem;
      color: #e67e22;
    }

    .cart-items {
      margin-bottom: 1rem;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      padding: 0.5rem 0;
      border-bottom: 1px solid #eee;
      font-size: 0.9rem;
    }

    h2 {
      margin-bottom: 1.5rem;
      color: #e67e22;
      text-align: center;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      text-align: left;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1.5rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      resize: vertical;
      transition: border-color 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    textarea:focus {
      border-color: #e67e22;
      outline: none;
      box-shadow: 0 0 5px rgba(230, 126, 34, 0.3);
    }

    button {
      background-color: #e67e22;
      border: none;
      color: #fff;
      padding: 1rem 2rem;
      font-size: 1.1rem;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 100%;
    }

    button:hover {
      background-color: #cf6a14;
    }

    button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }

    .back-to-cart {
      display: inline-block;
      margin-bottom: 1rem;
      padding: 0.5rem 1rem;
      background-color: #6c757d;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .back-to-cart:hover {
      background-color: #5a6268;
    }

    .empty-cart {
      text-align: center;
      color: #666;
      padding: 2rem;
    }

    .error-message {
      background-color: #f8d7da;
      color: #721c24;
      padding: 1rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      border: 1px solid #f5c6cb;
    }

    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
      }

      .image-section img {
        height: 300px;
      }

      .form-section {
        padding: 1rem;
      }

      .form-container {
        padding: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="main-container">
    <div class="image-section">
      <img src="images/track-order.gif" alt="Order tracking">
    </div>
    <div class="form-section">
      <div class="form-container">
        <a href="cart.php" class="back-to-cart">← Back to Cart</a>
        
        <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
          <h3>Your cart is empty</h3>
          <p>Please add some items to your cart before checkout.</p>
          <a href="menu.php" style="color: #e67e22; text-decoration: none;">← Continue Shopping</a>
        </div>
        <?php else: ?>
        
        <!-- Order Summary -->
        <div class="order-summary">
          <h3>Order Summary</h3>
          <div class="cart-items">
            <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
              <span><?php echo htmlspecialchars($item['title']); ?> (x<?php echo $item['quantity']; ?>)</span>
              <span>Rs. <?php echo number_format($item['total'], 2); ?></span>
            </div>
            <?php endforeach; ?>
          </div>
          <table>
            <tr>
              <td>Subtotal:</td>
              <td>Rs. <?php echo number_format($cartSubtotal, 2); ?></td>
            </tr>
            <tr>
              <td>Delivery Fee:</td>
              <td>Rs. <?php echo number_format($deliveryFee, 2); ?></td>
            </tr>
            <tr class="total-row">
              <td>Total:</td>
              <td>Rs. <?php echo number_format($grandTotal, 2); ?></td>
            </tr>
          </table>
        </div>

        <h2>Enter Your Checkout Details</h2>

        <?php if (!empty($errors)): ?>
        <div class="error-message">
          <?php foreach ($errors as $error): ?>
            <div><?php echo htmlspecialchars($error); ?></div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="" method="POST" id="checkoutForm">
          <label for="name">Full Name: <span style="color: red;">*</span></label>
          <input
            type="text"
            id="name"
            name="fullname"
            required
            placeholder="Your full name"
            value="<?php echo htmlspecialchars($fullname); ?>"
          />

          <label for="email">Email Address: <span style="color: red;">*</span></label>
          <input
            type="email"
            id="email"
            name="email"
            required
            placeholder="you@example.com"
            value="<?php echo htmlspecialchars($email); ?>"
          />

          <label for="address">Shipping Address: <span style="color: red;">*</span></label>
          <textarea
            id="address"
            name="address"
            rows="4"
            required
            placeholder="Your complete shipping address"
          ><?php echo htmlspecialchars($address); ?></textarea>

          <label for="phone">Phone Number: <span style="color: red;">*</span></label>
          <input
            type="tel"
            id="phone"
            name="phone"
            required
            placeholder="0771234567"
            value="<?php echo htmlspecialchars($phone); ?>"
          />

          <button type="submit" id="submitBtn">
            Place Order - Rs. <?php echo number_format($grandTotal, 2); ?>
          </button>
        </form>
        
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php include 'footer.php'; ?>

<!-- SweetAlert Messages -->
<?php if ($orderPlaced): ?>
<script>
Swal.fire({
  title: 'Order Placed Successfully!',
  text: 'Your order has been confirmed and Payment will be collected on delivery.',
  icon: 'success',
  confirmButtonText: 'View My Orders',
  allowOutsideClick: false
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = 'login.php';
  } else {
    window.location.href = 'home.php';
  }
});
</script>
<?php endif; ?>

<script>
// Form validation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
  const submitBtn = document.getElementById('submitBtn');
  submitBtn.disabled = true;
  submitBtn.textContent = 'Processing...';
  
  // Re-enable button after 5 seconds to prevent permanent disable
  setTimeout(() => {
    submitBtn.disabled = false;
    submitBtn.textContent = 'Place Order - Rs. <?php echo number_format($grandTotal, 2); ?>';
  }, 5000);
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function(e) {
  let value = e.target.value.replace(/\D/g, '');
  if (value.length > 10) {
    value = value.substring(0, 10);
  }
  e.target.value = value;
});
</script>

</body>
</html>