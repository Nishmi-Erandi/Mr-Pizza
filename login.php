<?php
session_start();
include 'db.php';
include 'nav.php';?>

<?php
$message = "";
$messageType = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $message = "Please enter both email and password";
        $messageType = "error";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format";
        $messageType = "error";
    } else {
        $query = "SELECT * FROM users WHERE Email = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['user_id'];
                $_SESSION['user_name'] = $user_data['first_name'] . ' ' . $user_data['last_name'];
                $_SESSION['user_email'] = $user_data['email'];

                $message = "Click OK See Your Order!";
                $messageType = "success";
            } else {
                $message = "Incorrect password";
                $messageType = "error";
            }
        } else {
            $message = "Email not registered";
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=National+Park:wght@200..800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="login.css">

    <style>
        * {
            padding: 0;
            margin: 0;
        }
        .log {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-areas:
            "image contain"
            "image contain";
            min-height: 100vh;
        }
        .image {
            grid-area: image;
            overflow: hidden;
        }
        .image img {
            max-width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .contain {
            grid-area: contain;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 5rem 0rem;
        }
        .contain h1 {
            font-size: 4.5rem;
            font-family: "Roboto Condensed", sans-serif;
            color: #5C2E00;
        }
        .contain h4 {
            font-size: 1.5rem;
            font-weight: 500;
            font-family: "Roboto Condensed", sans-serif;
            color: #FF6600;
            padding: 1rem 0rem;
        }
        .contain label {
            font-size: 1.5rem;
            font-family: 'Poppins', sans-serif;
        }
        .contain input {
            font-size: 1rem;
            padding: 0.5rem;
            border-radius: 10px;
            border: solid black 1px;
            width: 100%;
            margin: 1rem 0rem;
        }
        .contain input:hover {
            border: rgb(182, 5, 5) solid 1px;
        }
        .contain button {
            width: 100%;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            border-radius: 50px;
            border-style: none;
            cursor: pointer;
            background-color: #00C700;
            color: aliceblue;
        }
        .contain button:hover {
            background-color: #00b300;
            transform: scale(1.02);
            transition: 0.2s ease-in-out;
        }
        form {
            width: 60%;
        }
        p {
            font-size: 1.2rem;
            color: DarkGray;
        }
        a {
            text-decoration: none;
            color: #2E8B57;
        }
        a:hover {
            text-decoration: underline;
            color: #388E3C;
        }

        @media (max-width: 768px) {
            .log {
                grid-template-columns: 1fr;
                grid-template-areas:
                "image"
                "contain";
            }
            .contain button,
            .contain input,
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<?php if (!empty($message)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: '<?php echo $messageType === "success" ? "Success" : "Error"; ?>',
            text: '<?php echo $message; ?>',
            icon: '<?php echo $messageType; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed && '<?php echo $messageType; ?>' === 'success') {
                window.location.href = 'myOrder.php';  // ✅ Redirect on success
            }
        });
    });
</script>
<?php endif; ?>

<div class="log">
    <div class="contain">
        <h1>Login</h1>
        <h4>Your favorite meals miss you—log in now!</h4>

        <form method="POST">
            <label for="email">Email</label><br>
            <input type="email" id="email" required autofocus name="email" autocomplete="on"
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required autocomplete="on"><br>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="signup.php">Create one now</a></p>
        </form>
    </div>

    <div class="image">
        <img src="images/logIn.jpg" alt="Login Image">
    </div>
</div>

</body>
</html>
