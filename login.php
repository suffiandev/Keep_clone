<?php
include('db.php')
?>
<?php
session_start();
$showForm = true; // Variable to control form visibility
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: add_note.php");
            exit();
        } else {
            $showForm = false; // Hide the form
            echo "<div class='valid'>
            <h3>Incorrect Username/password.</h3><br/>
            <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
            </div>";
        }
    } else {
        $showForm = false; // Hide the form
        echo "<div class='valid'>
        <h3>User not found.</h3><br/>
        <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
        </div>";
    }
}
$conn->close();
?>

<!-- login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class='register-form'>
        <?php if ($showForm): ?>
            <form class='register-form-inner' action="login.php" method="post">
                <h1 class="login-title">Login</h1>
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" value="Login">
                <p class="link">Don't have an account? <a href="index.php">Registration Now</a></p>
           </form>
        <?php endif; ?>
    </div>
</body>
</html>
