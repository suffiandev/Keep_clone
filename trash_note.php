<?php
include('db.php')
?>
<?php
include('header.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Fetch trashed notes from the database
$sql = "SELECT * FROM notes WHERE is_trashed = true";
$result = $conn->query($sql);

// Check if there are any trashed notes
if ($result->num_rows > 0) {
    $trashed_notes = $result->fetch_all(MYSQLI_ASSOC);
    echo '<div class="flex-view">';
    echo '<div class="notes-list-trash">';
    foreach ($trashed_notes as $note) {
        echo '<div class="note">';
        echo '<div class="edited">';
        echo '<h2>' . htmlspecialchars($note['title']) . '</h2>';
        echo '<p class="note-content">' . htmlspecialchars($note['content']) . '</p>';
        echo '</div>';
        echo '<div class="archive-form">';
        echo '<form method="post" action="restore_note.php">';
        echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
        echo '<button type="submit" name="restore_note" onmouseover="showMessage(\'hoverRestoreMessage_' . $note['id'] . '\')" onmouseout="hideMessage(\'hoverRestoreMessage_' . $note['id'] . '\')">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
        echo '<path fill="currentColor" d="M14 14h2l-4-4l-4 4h2v4h4v-4M6 7h12v12c0 .5-.2 1-.61 1.39c-.39.41-.89.61-1.39.61H8c-.5 0-1-.2-1.39-.61C6.2 20 6 19.5 6 19V7m13-3v2H5V4h3.5l1-1h5l1 1H19Z"/>';
        echo '</svg>';
        echo '</button>';
        echo '<div id="hoverRestoreMessage_' . $note['id'] . '">Restore</div>';
        echo '</form>';
        echo '<form method="post" action="delete_permanent_note.php">';
        echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
        echo '<button type="submit" name="delete_permanent_note" onmouseover="showMessage(\'hoverDeletePermanentMessage_' . $note['id'] . '\')" onmouseout="hideMessage(\'hoverDeletePermanentMessage_' . $note['id'] . '\')">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
        echo '<path fill="currentColor" d="M7.5 1h9v3H22v2h-2.029l-.5 17H4.529l-.5-17H2V4h5.5V1Zm2 3h5V3h-5v1ZM6.03 6l.441 15h11.058l.441-15H6.03Zm3.142 3.257L12 12.086l2.828-2.829l1.415 1.415l-2.829 2.828l2.829 2.828l-1.415 1.415L12 14.914l-2.828 2.829l-1.415-1.415l2.829-2.828l-2.829-2.828l1.415-1.415Z"/>';
        echo '</svg>';
        echo '</button>';
        echo '<div id="hoverDeletePermanentMessage_' . $note['id'] . '">Delete forever</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    // Display a message when there are no trashed notes
    echo '<div class="not-found-view">';
    echo '<img class="bulb-img" src="image/delete.svg" alt="not found"/>';
    echo '<p class="not-found-content">No notes in Trash</p>';
    echo '</div>';
}
$conn->close();
?>
<script src="script.js"></script>
</body>
</html>