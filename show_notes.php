<?php
include('db.php');
?>

<?php
// Fetch all notes from the database
$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

// Check if there are any notes
if ($result->num_rows > 0) {
    $notes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $notes = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<div class="notes-list" id="notesList">
        <!-- Notes will be dynamically added here -->
        <?php foreach ($notes as $note): ?>
            <div class="note">
                <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                <p><?php echo htmlspecialchars($note['content']); ?></p>
                <!-- Add Archive button with a form for each note -->
                <form method="post" action="archive_note.php">
                    <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                    <button type="submit" name="archive_note">Archive</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
