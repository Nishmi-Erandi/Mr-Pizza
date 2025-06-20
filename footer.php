<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .footer {
  background-color: #3a2600;
  color: #fff;
  padding: 3rem 2rem;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 2rem;
}

.footer-section h3 {
  margin-bottom: 1rem;
  color: #fff;
  font-weight: bold;
  position: relative;
}

.footer-section h3::after {
  content: "";
  display: block;
  width: 40px;
  height: 2px;
  background-color: #c6d200;
  margin-top: 5px;
}

.footer-section p,
.footer-section a {
  color: #ccc;
  font-size: 0.95rem;
  text-decoration: none;
}

.footer-section a:hover {
  color: #fff;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section li {
  margin-bottom: 0.5rem;
}

.logo {
  width: 120px;
  margin-bottom: 1rem;
}

.social-icons {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.social-icons .icon {
  background-color: #5a3f00;
  color: #fff;
  padding: 0.6rem 1rem;
  border-radius: 50%;
  font-weight: bold;
  text-decoration: none;
  transition: background 0.3s;
}

.social-icons .icon:hover {
  background-color: #c6d200;
  color: #000;
}

    </style>
    <title>Document</title>
</head>
<body>
    <footer class="footer">
  <div class="footer-container">
    <!-- Logo and Description -->
    <div class="footer-section">
      <img src="images/logo.png" alt="Mr. Pizza Logo" class="logo">
      <p>Delicious food made with the freshest ingredients, delivered right to your doorstep.</p>
    </div>

    <!-- Quick Links -->
    <div class="footer-section">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        
        <li><a href="login.php">My Order</a></li>
        <li><a href="cart.php">My Order</a></li>
       
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="footer-section">
      <h3>Contact Us</h3>
      <p>📍</p>
      <p>📞 </p>
      <p>✉️ info@mrpizza.com</p>
      <p>⏰ Mon–Sun | 11AM – 11PM</p>
    </div>

    <!-- Social Media -->
    <div class="footer-section">
      <h3>Stay Connected</h3>
      <p>Follow us on social media for updates, special offers, and more!</p>
      <div class="social-icons">
        <a href="" class="icon">FB</a>
        
      </div>
    </div>
  </div>
</footer>

</body>
</html>