<?php
include('db.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .no-archived-notes {
            background-color: black;
            font-size: 18px;
            font-weight: bold;
            color: #555;
            text-align: center;
            margin-top: 20px;
        }
    </style>
    <title>Document</title>
</head>
<body>

<?php
// ... (your existing code above)

if (isset($_GET['view']) && $_GET['view'] === 'archive') {
    // Fetch and display archived notes
    $sqlAllArchived = "SELECT * FROM notes WHERE is_archived = true";
    $resultAllArchived = $conn->query($sqlAllArchived);

    if ($resultAllArchived->num_rows > 0) {
        $allArchivedNotes = $resultAllArchived->fetch_all(MYSQLI_ASSOC);

        echo '<div class="flex-view">';
        echo '<div class="notes-list-archive">';
        foreach ($allArchivedNotes as $note) {
            echo '<div class="note">';
            echo '<h2>' . htmlspecialchars($note['title']) . '</h2>';
            echo '<p class="note-content">' . htmlspecialchars($note['content']) . '</p>';
            echo '<div class="archive-form">';
            echo '<form method="post" action="unarchive_note.php">';
            echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
            echo '<button type="submit" name="archive_note">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 24">';
            echo '<path fill="currentColor" d="m12 18l4-4l-1.4-1.4l-1.6 1.6V10h-2v4.2l-1.6-1.6L8 14l4 4ZM5 8v11h14V8H5Zm0 13q-.825 0-1.413-.588T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.588 1.413T19 21H5Zm.4-15h13.2l-.85-1H6.25L5.4 6Zm6.6 7.5Z"/>';
            echo '</svg>';
            echo '</button>';
            echo '</form>';
            echo '<form method="post" action="delete_note.php">';
            echo '<input type="hidden" name="note_id" value="' . $note['id'] . '">';
            echo '<button type="submit" name="delete_note">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 24 24">';
            echo '<path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7Zm2-4h2V8H9v9Zm4 0h2V8h-2v9Z"/>';
            echo '</svg>';
            echo '</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="no-archived-notes">';
        echo '<h1>No archived notes.</h1>';
        echo '</div>';
    }
} else {
    // Display a default message or handle other views
    echo "Invalid view or no view specified.";
}

$conn->close();
?>

<script src="script.js"></script>
</body>
</html>
