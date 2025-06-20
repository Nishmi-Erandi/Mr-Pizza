<?php
session_start();
include 'db.php';
include 'nav.php';?>

<?php

$message = "";
$messageType = "";

if($_SERVER['REQUEST_METHOD'] == "POST") {
    // Get and sanitize user inputs
    $firstName = mysqli_real_escape_string($con, trim($_POST['fname']));
    $lastName = mysqli_real_escape_string($con, trim($_POST['lname']));
    $address = mysqli_real_escape_string($con, trim($_POST['address']));
    $phoneNumber = mysqli_real_escape_string($con, trim($_POST['pnumber']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));
    $password = $_POST['password'];

    // Input validation
    $errors = [];
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate phone number (basic check for digits)
    if (!preg_match("/^[0-9]{10,15}$/", $phoneNumber)) {
        $errors[] = "Invalid phone number (should be 10 digits)";
    }
    
    // Password strength check
    if (strlen($password) < 5) {
        $errors[] = "Password must be at least 5 characters long";
    }
    
    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE Email = ?";
    $stmt = mysqli_prepare($con, $checkEmail);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Email already registered";
    }
    
    // If there are no errors, insert into database
    if (empty($errors)) {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare and execute the insert query
        $query = "INSERT INTO users (first_name, last_name, address, phone_number, email, password) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $firstName, $lastName, $address, $phoneNumber, $email, $hashedPassword);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Registration successful!";
            $messageType = "success";
        } else {
            $message = "Error: " . mysqli_error($con);
            $messageType = "error";
        }
    } else {
        $message = implode("<br>", $errors);
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=National+Park:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signUp.css">
    <title>Sign Up</title>
    <style>
        *{
    padding: 0;
    margin: 0;
   
}
.signup{
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-areas: 
            "img content"
            "img content";
    min-height: 100vh;
    
  
            
}
.img{
    grid-area: img;
    overflow: hidden;
    
}
.img img{
    max-width: 100%;
    height: 100%;
    object-fit: cover;
    
    
}

.content{
    grid-area: content;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
   
    
}
.content h1{
    font-size: 4rem;
    padding: 1.5rem 0rem;
    font-family: "Roboto Condensed", sans-serif;
    color: rgb(141, 2, 2);
   
}
.content h4{
    font-size: 1.5rem;
    font-weight: 500;
    font-family: "Roboto Condensed", sans-serif;
    color: rgb(63, 0, 0);
    padding-bottom: 1rem;
}
.content label{
    font-size: 1.2rem;
    font-family: "Roboto Condensed", sans-serif;
    margin-bottom: 2rem;
  
    
}
.content input{
    font-size: 1rem;
    padding: 0.5rem;
    border-radius: 10px;
    border-style: none;
    border: solid black 1px;
    width: 100%;
   
}
.content input:hover{
    border: rgb(182, 5, 5) solid 1px;
}
.content button{
    width: 100%;
    font-size: 1.2rem;
    margin: 1.5rem 0rem;
    padding: 0.5rem;
    border-radius: 50px;
    border-style: none;
    cursor: pointer;
    background-color: rgb(9, 173, 9);
    color: aliceblue;
}
.content button:hover{
    background-color: rgb(30, 249, 30);
}
form{
    width: 60%;

}
p{
    font-size: 1.2rem;
}
a{
    text-decoration: none;
    color:#2E8B57;
}
a:hover {
    text-decoration: underline;
    color: #388E3C;
  }




@media (max-width: 768px) {
    .signup {
        grid-template-columns: 1fr;
        grid-template-areas:
            "img"
            
            "content";
    }

    .content button {
        width: 100%;
    }

    .content input {
        width: 100%;
    }
   
    .form {
        width: 90%;
    }
    .content h4{
        padding: 0px 20px;

    }
      
}
    </style>
</head>
<body>
    <?php if (!empty($message)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<?php echo $messageType === "success" ? "Successful! Redirecting to home page..." : "Error"; ?>',
                text: '<?php echo $message; ?>',
                icon: '<?php echo $messageType; ?>',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed && '<?php echo $messageType; ?>' === 'success') {
                    window.location.href = 'home.php'; // Redirect to home page on success
                }
            });
        });
    </script>
    <?php endif; ?>

    <div class="signup">
        <div class="img">
            <img src="images/side.jpg" alt="Signup Image">
        </div>

        <div class="content">
            <h1>Sign Up</h1>
            <h4>One step away from tasty-register now to order!</h4>

            <form method="POST">
                <label for="fname">First Name</label><br>
                <input type="text" id="fname" name="fname" ><br>
                
                <label for="lname">Last Name</label><br>
                <input type="text" id="lname" name="lname" ><br>
                
                <label for="address">Address</label><br>
                <input type="text" id="address" name="address" ><br>
                
                <label for="pnumber">Phone Number</label><br>
                <input type="tel" id="pnumber" name="pnumber"  
                       placeholder="Enter digits only"><br>
                
                <label for="email">Email</label><br>
                <input type="email" id="email" name="email"><br>
                
                <label for="password">Password</label><br>
                <input type="password" id="password" name="password" required 
                       placeholder="At least 5 characters"><br>
                
                <button type="submit">Submit</button>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>

    
</body>
</html>