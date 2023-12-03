<?php
include('db.php');
if (isset($_POST['delete_permanent_note'])) {
    // Ensure the note_id is set and is a valid integer
    $note_id = filter_input(INPUT_POST, 'note_id', FILTER_VALIDATE_INT);
    if ($note_id !== false) {
        // Delete the note permanently
        $sql = "DELETE FROM notes WHERE id = $note_id";

        if ($conn->query($sql)) {
            // Deletion successful
            header("Location: trash_note.php"); // Refresh the page to reflect changes
            exit();
        } else {
            // Error handling if deletion fails
            echo "Error deleting note permanently: " . $conn->error;
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