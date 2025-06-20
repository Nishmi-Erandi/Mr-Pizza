<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'NErandi7' && $password == 'NE12345') {
        // Successful login, redirect to adMenu.php
        header('Location: adMenu.php');
        exit;
    } else {
        $error = "Invalid Username or Password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin-Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900" rel="stylesheet">
<style>
body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:'Roboto', sans-serif;
    color: #fff;
    background: linear-gradient( 135deg,rgb(92, 24, 19),rgba(255, 208, 0, 0.99) );
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 50px;
    padding: 20px;
    flex-wrap: wrap;
    max-width: 1000px;
    margin: 0 auto;
}

.container .logo,
.container .login-form {
    flex: 1;
    min-width: 280px;
}

.container .logo img {
    max-width: 400px;
    height: auto;
    display: block;
    margin: 0 auto;
}

.container .login-form {
    background: #edf5ff;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 0 30px 5px rgb(0 0 0 / 60%);
    max-width: 350px;
    width: 100%;
    color: #000;
    text-align: center;
}

.container .login-form h2 {
    margin-bottom: 30px;
    color: #5c1813;
    font-size: 1.5rem;
    font-weight: bold;
}

.container .login-form label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: #000;
    text-align: left;
    font-size: 1.1rem;
}

.container .login-form input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 1rem;
    box-sizing: border-box;
    transition: 0.3s;
}

.container .login-form input:focus {
    outline: none;
    border-color: #5c1813;
    box-shadow: 0 0 5px 2px #ffbaba;
}

.container .login-form button {
    width: 100%;
    padding: 12px;
    background: #5c1813;
    color: #ffffff;
    font-weight: bold;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    transition: 0.3s;
    cursor: pointer;
}

.container .login-form button:hover {
    background: #883b21;
}

@media (max-width: 768px) {
    .container {
        flex-direction: column;
        align-items: center;
    }
    .container .logo img {
        max-width: 250px;
        margin-bottom: 20px;
    }
}
</style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="images/logo.png" alt="Mr.Pizza">
        </div>
        <div class="login-form">
            <h2>Admin Login</h2>
            <?php if (!empty($error)): ?>
                <p style="color: red; margin-bottom: 20px;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" required>

                <label for="password">Password</label>
                <input id="password" name="password" type="password" required>

                <button type="submit">Log In</button>
            </form>
        </div>
    </div>
</body>
</html>
