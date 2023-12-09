<?php
include('db.php');
include('header.php');
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['archive_note'])) {
    $noteId = $_POST['note_id'];
    $updateSql = "UPDATE notes SET is_archived = true WHERE id = $noteId";
    if ($conn->query($updateSql) === TRUE) {
        // Fetch the updated archived note
        $archivedSql = "SELECT * FROM notes WHERE id = $noteId AND is_archived = true";
        $archivedResult = $conn->query($archivedSql);
        if ($archivedResult->num_rows > 0) {
            $archivedNote = $archivedResult->fetch_assoc();
            // Return the HTML content of the archived note
            echo '<div class="note">
                <div class="note-box">
                    <h2>' . htmlspecialchars($archivedNote['title']) . '</h2>
                    <p>' . htmlspecialchars($archivedNote['content']) . '</p>
                </div>
            </div>';
        header("Location: add_note.php");
        exit; // Ensure that no further code is executed after the redirect
        }
        // Fetch all archived notes from the database excluding the recently archived note
        $sqlAllArchived = "SELECT * FROM notes WHERE is_archived = true AND id != $noteId";
        $resultAllArchived = $conn->query($sqlAllArchived);
        if ($resultAllArchived->num_rows > 0) {
            $allArchivedNotes = $resultAllArchived->fetch_all(MYSQLI_ASSOC);
            // Display all archived notes
            echo '<div class="notes-list" id="archivedNotesList">';
            foreach ($allArchivedNotes as $note) {
                echo '<div class="note">
                        <div class="note-box">
                            <h2>' . htmlspecialchars($note['title']) . '</h2>
                            <p>' . htmlspecialchars($note['content']) . '</p>
                        </div>
                      </div>';
            }
            echo '</div>';
        } else {
            // Display a message when there are no archived notes
            echo "No archived notes.";
        }
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
} else {
    if (isset($_GET['view']) && $_GET['view'] === 'archive') {
        // Fetch and display archived notes
        $sqlAllArchived = "SELECT * FROM notes WHERE is_archived = true AND is_trashed = false";
        $resultAllArchived = $conn->query($sqlAllArchived);
    
        if ($resultAllArchived->num_rows > 0) {
            $allArchivedNotes = $resultAllArchived->fetch_all(MYSQLI_ASSOC);
    
            echo '<div class="flex-view">';
            echo '<div class="notes-list-archive">';
            foreach ($allArchivedNotes as $note) {
                echo '<div class="note" data-note-id="' . $note['id'] . '" onclick="expandShowNote(this)">';
                echo '<div class="edited">';
                echo '<h2>' . htmlspecialchars($note['title']) . '</h2>';
                echo '<p class="note-content">' . htmlspecialchars($note['content']) . '</p>';
                echo '</div>';
                echo '<div class="archive-form">';
                echo '<form method="post" action="unarchive_note.php">';
                echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
                echo '<button type="submit" name="archive_note" onmouseover="showMessage(\'hoverUnarchiveMessage_' . $note['id'] . '\')" onmouseout="hideMessage(\'hoverUnarchiveMessage_' . $note['id'] . '\')">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 24">';
                echo '<path fill="currentColor" d="m12 18l4-4l-1.4-1.4l-1.6 1.6V10h-2v4.2l-1.6-1.6L8 14l4 4ZM5 8v11h14V8H5Zm0 13q-.825 0-1.413-.588T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.588 1.413T19 21H5Zm.4-15h13.2l-.85-1H6.25L5.4 6Zm6.6 7.5Z"/>';
                echo '</svg>';
                echo '</button>';
                echo '<div id="hoverUnarchiveMessage_' . $note['id'] . '">Unarchive</div>';
                echo '</form>';
                echo '<form method="post" action="delete_note.php">';
                echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
                echo '<button type="submit" name="delete_note" onmouseover="showMessage(\'hoverDeleteMessage_' . $note['id'] . '\')" onmouseout="hideMessage(\'hoverDeleteMessage_' . $note['id'] . '\')">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 24 24">';
                echo '<path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7Zm2-4h2V8H9v9Zm4 0h2V8h-2v9Z"/>';
                echo '</svg>';
                echo '</button>';
                echo '<div id="hoverDeleteMessage_' . $note['id'] . '">Delete</div>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="not-found-view">';
            echo '<img class="bulb-img" src="image/archive.svg" alt="not found"/>';
            echo '<p class="not-found-content">Your archived notes appear here</p>';
            echo '</div>';
        }
    } else {
        // Display a default message or handle other views
        echo "Invalid view or no view specified.";
    }
}
    
    $conn->close();
    ?>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>
</html>