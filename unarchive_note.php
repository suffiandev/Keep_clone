<?php
include('db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id'])) {
    $noteId = $_POST['note_id'];
    // Update the note to unarchive
    $updateSql = "UPDATE notes SET is_archived = false WHERE id = $noteId";
    if ($conn->query($updateSql) === TRUE) {
        // Redirect back to add_note.php
        header("Location: archive_note.php?view=archive");
        exit();
    } else {
        echo "Error unarchiving note: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
$conn->close();
?>
