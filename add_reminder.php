<?php
include('db.php')
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noteId = $_POST['noteId'];
    $reminderDate = $_POST['reminderDate'];
    $reminderTime = $_POST['reminderTime'];

    // Combine the date and time to create a DATETIME string
    $reminderDateTime = $reminderDate . ' ' . $reminderTime;
    // Perform database insertion using the included connection
    $sql = "INSERT INTO reminders (note_id, reminder_datetime) VALUES ('$noteId', '$reminderDateTime')";

    if ($conn->query($sql) === TRUE) {
        echo 'Reminder saved successfully';
    } else {
        echo 'Error saving reminder: ' . $conn->error;
    }
}
?>
