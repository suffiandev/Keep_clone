<?php
include('db.php');
// error_log(print_r($_POST, true));
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['note_id']) && isset($_POST['new_title']) && isset($_POST['new_content'])) {
    $noteId = $_POST['note_id'];
    $newTitle = $_POST['new_title'];
    $newContent = $_POST['new_content'];
    $updateSql = "UPDATE notes SET title = '$newTitle', content = '$newContent' WHERE id = $noteId";
    if ($conn->query($updateSql) === TRUE) {
        echo "Note updated successfully!";
    } else {
        echo "Error updating note: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
$conn->close();
?>
