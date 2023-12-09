<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_note'])) {
    // Ensure the note_id is set and is a valid integer
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    if ($note_id !== false) {
        // Update the note to be trashed
        $sql = "UPDATE notes SET is_trashed = true WHERE id = $note_id";

        if ($conn->query($sql)) {
            // Move to trash successful
            header("Location: archive_note.php?view=archive"); 
            exit();
        } else {
            echo "Error moving note to trash: " . $conn->error;
        }
    } else {
        echo "Invalid note ID.";
    }
} else {
    header("Location: add_note.php");
    exit();
}
?>
