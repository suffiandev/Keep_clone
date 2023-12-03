<?php
include('db.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Notes</title>
    <!-- Include your CSS stylesheets and other meta tags as needed -->
    <style>
        .delete-icon {
            display: none; /* Initially hide the delete icon */
            border:none;
            background:none;
        }
    </style>
</head>
<body>

<?php
// Fetch reminder notes from the database
$sql = "SELECT n.id, n.title, n.content, r.reminder_datetime
        FROM notes n
        LEFT JOIN reminders r ON n.id = r.note_id
        WHERE r.reminder_datetime IS NOT NULL";
$result = $conn->query($sql);

// Check if there are any reminder notes
if ($result->num_rows > 0) {
    $reminder_notes = $result->fetch_all(MYSQLI_ASSOC);
    echo '<div class="flex-view">';
    echo '<div class="notes-list-reminders">';
    foreach ($reminder_notes as $reminder) {
        echo '<div class="note">';
        echo '<div class="edited">';
        echo '<h2>' . htmlspecialchars($reminder['title']) . '</h2>';
        echo '<p class="note-content">' . htmlspecialchars($reminder['content']) . '</p>';
        echo '<p class="reminder-datetime" onmouseover="showDeleteIcon(this)" onmouseout="hideDeleteIcon(this)"> ' . htmlspecialchars($reminder['reminder_datetime']) . 
         '<button class="delete-icon" onclick="deleteNote(' . $reminder['id'] . ')">';
        echo '<img src="image/close.png"/ alt="not found" width="10" height="10">';
        echo '</button>';
        echo '</p>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    // Display a message when there are no reminder notes
    echo '<div class="not-found-view">';
    echo '<img class="bulb-img" src="image/reminder.svg" alt="not found"/>';
    echo '<p class="not-found-content">Notes with upcoming reminders appear here</p>';
    echo '</div>';
}
$conn->close();
?>

<script src="script.js"></script>

<script>
    // Function to show the delete icon
    function showDeleteIcon(element) {
        var deleteIcon = element.parentNode.querySelector('.delete-icon');
        if (deleteIcon) {
            deleteIcon.style.display = 'inline-block';
        }
    }

    // Function to hide the delete icon
    function hideDeleteIcon(element) {
        var deleteIcon = element.parentNode.querySelector('.delete-icon');
        if (deleteIcon) {
            deleteIcon.style.display = 'none';
        }
    }

    // Function to handle the delete action
    function deleteNote(noteId) {
        // Implement your delete logic here, e.g., make an AJAX request to delete the note
        console.log('Deleting note with ID:', noteId);

        // Assuming you have a separate PHP script for handling the deletion
        // You can make an AJAX request to delete the note using fetch or XMLHttpRequest
        fetch('delete_reminder.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ noteId: noteId }),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response, e.g., refresh the page or update the UI
            console.log(data);

            // Reload the page after successfully deleting the reminder
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>
</html>
