<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_note'])) {
    // Ensure the note_id is set and is a valid integer
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    if ($note_id !== false) {
        // Update the note to be not trashed
        $sql = "UPDATE notes SET is_trashed = false WHERE id = $note_id";
        if ($conn->query($sql)) {
            header("Location: trash_note.php"); // Refresh the page to reflect changes
            exit();
        } else {
            echo "Error restoring note: " . $conn->error;
        }
    } else {
        // Invalid note_id
        echo "Invalid note ID.";
    }
} else {
    // Redirect to the main page if accessed without a valid POST request
    header("Location: trash_note.php");
    exit();
}
?>
