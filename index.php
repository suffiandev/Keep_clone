<?php
include('db.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class='register-form'>
        <form class='register-form-inner' action="" method="post">
            <h1 class="login-title">Registration</h1>
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Register">
            <p class="link">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
</body>
</html>
