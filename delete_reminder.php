<?php
include('db.php');

// Ensure that the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON data sent from the client
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the 'noteId' is present in the decoded data
    if (isset($data['noteId'])) {
        // Sanitize the input to prevent SQL injection
        $noteId = mysqli_real_escape_string($conn, $data['noteId']);

        // Perform the deletion of the corresponding reminder
        $sql = "DELETE FROM reminders WHERE note_id = '$noteId'";

        if ($conn->query($sql) === TRUE) {
            // Send a success response
            echo json_encode(['success' => true, 'message' => 'Reminder deleted successfully']);
        } else {
            // Send an error response
            echo json_encode(['success' => false, 'message' => 'Error deleting reminder: ' . $conn->error]);
        }
    } else {
        // Send an error response if 'noteId' is not present in the data
        echo json_encode(['success' => false, 'message' => 'Note ID not provided']);
    }
} else {
    // Send an error response if the request is not a POST request
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

// Close the database connection
$conn->close();
?>
