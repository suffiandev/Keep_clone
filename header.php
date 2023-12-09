<?php
include('db.php')
?>
<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle unauthorized access
    header("Location: header.php");
    exit();
}
// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$username = ''; // Set a default value to avoid undefined variable notice
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">  
    <title>Google Keep</title>
</head>
<body>

<div class="menu">
    <div class='drawar-outer'>
        <div class='drawer-list'>
            <div class='drawer-item-list'>
                <a class="element" href="add_note.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 36 36"><path fill="currentColor" d="m33 6.4l-3.7-3.7a1.71 1.71 0 0 0-2.36 0L23.65 6H6a2 2 0 0 0-2 2v22a2 2 0 0 0 2 2h22a2 2 0 0 0 2-2V11.76l3-3a1.67 1.67 0 0 0 0-2.36ZM18.83 20.13l-4.19.93l1-4.15l9.55-9.57l3.23 3.23ZM29.5 9.43L26.27 6.2l1.85-1.85l3.23 3.23Z" class="clr-i-solid clr-i-solid-path-1"/><path fill="none" d="M0 0h36v36H0z"/></svg></a>
                <a class="element" href="add_note.php">Notes</a>
            </div>
            <div class='drawer-item-list'>
                <a href="archive_note.php?view=archive"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 24">
                    <path fill="#000" d="m12 18l4-4l-1.4-1.4l-1.6 1.6V10h-2v4.2l-1.6-1.6L8 14l4 4ZM5 8v11h14V8H5Zm0 13q-.825 0-1.413-.588T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.588 1.413T19 21H5Zm.4-15h13.2l-.85-1H6.25L5.4 6Zm6.6 7.5Z"/>
                </svg></a>
                <a class="element" href="archive_note.php?view=archive">Archive</a>
            </div>
            <div class='drawer-item-list'>
                <a href="trash_note.php"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 24 24"><path fill="#000" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7Zm2-4h2V8H9v9Zm4 0h2V8h-2v9Z"/></svg></a>
                <a class="element" href="trash_note.php">Trash</a>
            </div>
            <div class='drawer-item-list'>
                <a href="get_reminders.php"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="#000" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M37.277 32.7V21.49A13.272 13.272 0 0 0 27.08 8.588v-.985a3.102 3.102 0 0 0-6.204 0V8.6a13.272 13.272 0 0 0-10.153 12.89V32.7l-4.206 4.206v1.943h34.966v-1.943Z"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M19.326 38.849a4.652 4.652 0 1 0 9.303 0"/></svg></a>
                <a class="element" href="get_reminders.php">Reminder</a>
            </div>
        </div>
    </div>
</div>
    
<div class="navbar">
    <div style='display:flex;gap:60px'>
        <div class="menu-btn-outer">
            <div class="menu-btn">&#9776;</div>
        </div>
        <img src="image/kepp_clone.png" alt="not found">
    </div>
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search...">
        <div id="noResultsMessage" style="display: none; text-align: center; padding: 10px;">
    No matching notes found.
</div>
    </div>
    <div>
        <!-- <a href="#notifications"></i> Notifications</a> -->
        <a href=""><?php echo $username ? $username : 'Profile'; ?></a>
        <a href="logout.php">Logout</a>
    </div>
</div>

