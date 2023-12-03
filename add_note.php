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
    <link rel="stylesheet" href="style.css">
    <title>Your Google Keep Project</title>
</head>
<body>

<main>
    <div id="noteContainer" class='add-form'>
        <form id="myForm" class="note-container" method="post" action="add_note.php">
            <input required type="text" name="note_title" id="noteTitle" placeholder="Title" style="display: none;">
            <textarea required name="note_content" id="noteContent" placeholder="Take a note..." onclick="expandNote()"></textarea>
            <button class="btn" type="submit" name="save_note" style="display: none;">Save</button>
        </form>
    </div>
</main>

<?php
// Fetch all non-archived notes from the database
$sql = "SELECT * FROM notes WHERE is_archived = false AND is_trashed = false";
$result = $conn->query($sql);

// Check if there are any notes
if ($result->num_rows > 0) {
    $notes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo '<div class="not-found-view">';
    echo '<img class="bulb-img" src="image/bulb.svg" alt="not found"/>';
    echo '<p class="not-found-content">Notes you add appear here.</p>';
    echo '</div>';
    $notes = [];
}
?>

<!-- Add the list of notes or other relevant content -->
<div class='flex-view'>
    <div class="notes-list" id="notesList">
        <?php foreach ($notes as $note): ?>
            <div class="note" data-note-id="<?php echo $note['id']; ?>" onclick="expandShowNote(this)">
                <div class='edited'>
                    <h2><?php echo htmlspecialchars($note['title']); ?></h2>
                    <p class="note-content"> <?php echo htmlspecialchars($note['content']); ?></p>
                </div>
                <div class="archive-form">
                    <form method="post" action="archive_note.php">
                        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                        <button type="submit" name="archive_note" onmouseover="showMessage('hoverArchiveMessage_<?php echo $note['id']; ?>')" onmouseout="hideMessage('hoverArchiveMessage_<?php echo $note['id']; ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="m12 18l4-4l-1.4-1.4l-1.6 1.6V10h-2v4.2l-1.6-1.6L8 14l4 4ZM5 8v11h14V8H5Zm0 13q-.825 0-1.413-.588T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.588 1.413T19 21H5Zm.4-15h13.2l-.85-1H6.25L5.4 6Zm6.6 7.5Z"/></svg>
                        </button>
                        <div id="hoverArchiveMessage_<?php echo $note['id']; ?>">Archive</div>
                    </form>
                    <form method="post" action="delete_note.php">
                        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                        <button type="submit" name="delete_note" onmouseover="showMessage('hoverDeleteMessage_<?php echo $note['id']; ?>')" onmouseout="hideMessage('hoverDeleteMessage_<?php echo $note['id']; ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7Zm2-4h2V8H9v9Zm4 0h2V8h-2v9Z"/></svg>
                        <div id="hoverDeleteMessage_<?php echo $note['id']; ?>">Delete</div>
                        </button>
                    </form>
                    <form method="post" action="add_reminder.php">
                        <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                        <button type="button" name="add_reminder" class="reminder-button" onclick="toggleReminderPicker('<?php echo $note['id']; ?>')" onmouseover="showMessage('hoverReminderMessage_<?php echo $note['id']; ?>')" onmouseout="hideMessage('hoverReminderMessage_<?php echo $note['id']; ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11.5 3A1.5 1.5 0 0 0 10 4.5v.71C7.69 5.86 6 8 6 10.5V16l-3 3h17l-3-3v-5.5c0-2.5-1.69-4.64-4-5.29V4.5A1.5 1.5 0 0 0 11.5 3m0 1a.5.5 0 0 1 .5.5v1.53c2.25.25 4 2.15 4 4.47v5.91L17.59 18H5.41L7 16.41V10.5c0-2.32 1.75-4.22 4-4.47V4.5a.5.5 0 0 1 .5-.5m-.5 6v2H9v1h2v2h1v-2h2v-1h-2v-2h-1M9.05 20a2.5 2.5 0 0 0 4.9 0h-1.04a1.495 1.495 0 0 1-2.82 0H9.05Z"/></svg>
                            <div id="hoverReminderMessage_<?php echo $note['id']; ?>">Add Reminder</div>
                        </button>
                    </form>
                    <!-- Date and time picker div -->
                    <div id="reminderPicker_<?php echo $note['id']; ?>" class="reminder-picker">
                        <label for="reminderDate">Date:</label>
                        <input type="date" id="reminderDate_<?php echo $note['id']; ?>" name="reminder_date" required>

                        <label for="reminderTime">Time:</label>
                        <input type="time" id="reminderTime_<?php echo $note['id']; ?>" name="reminder_time" required>

                        <button onclick="saveReminder(<?php echo $note['id']; ?>)">Save Reminder</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Expanded Note Box -->
<div class="expanded-note" id="expandNote" style="display: none;">
    <h2 id="expandedTitle"></h2>
    <p id="expandedContent"></p>
</div>

<!-- edit note  -->
<!-- Add a note -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_note'])) {
    $noteTitle = $_POST['note_title'];
    $noteContent = $_POST['note_content'];
    // Save the note to the database
    $sql = "INSERT INTO notes (title, content) VALUES ('$noteTitle', '$noteContent')";
    if ($conn->query($sql) === TRUE) {
        // Fetch the last inserted note
        $lastNoteId = $conn->insert_id;
        $lastNoteSql = "SELECT * FROM notes WHERE id = $lastNoteId";
        $result = $conn->query($lastNoteSql);
        if ($result->num_rows > 0) {
            $lastNote = $result->fetch_assoc();
            // Return the HTML content of the new note
            echo '<div class="flex-view">
                    <div class="notes-list-add-node">
                        <div class="note">
                            <h2>' . htmlspecialchars($lastNote['title']) . '</h2>
                            <p class="note-content">' . htmlspecialchars($lastNote['content']) . '</p>
                            <form class="archive-form" method="post" action="archive_note.php">
                                <input type="hidden" name="note_id" value="' . $lastNote['id'] . '">
                                <button type="submit" name="archive_note">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="m12 18l4-4l-1.4-1.4l-1.6 1.6V10h-2v4.2l-1.6-1.6L8 14l4 4ZM5 8v11h14V8H5Zm0 13q-.825 0-1.413-.588T3 19V6.525q0-.35.113-.675t.337-.6L4.7 3.725q.275-.35.687-.538T6.25 3h11.5q.45 0 .863.188t.687.537l1.25 1.525q.225.275.338.6t.112.675V19q0 .825-.588 1.413T19 21H5Zm.4-15h13.2l-.85-1H6.25L5.4 6Zm6.6 7.5Z"/>
                                    </svg>
                                </button>
                            </form>
                            <form class="archive-form" method="post" action="delete_note.php">
                                <input type="hidden" name="note_id" value="' . $lastNote['id'] . '">
                                <button type="submit" name="delete_note">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7Zm2-4h2V8H9v9Zm4 0h2V8h-2v9Z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="script.js"></script>
</body>
</html>