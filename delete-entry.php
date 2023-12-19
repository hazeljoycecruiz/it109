<?php
// Include or require the file where the database connection is established
include 'server.php'; // Update with the correct path

// Check if entry_id is provided in the URL
if (isset($_GET['entry_id'])) {
    $entryId = $_GET['entry_id'];

    // Perform the deletion
    $deleteQuery = "DELETE FROM entries WHERE entry_id = $entryId";

    if (mysqli_query($db, $deleteQuery)) {
        // Deletion successful
        $response = ['success' => true];
    } else {
        // Deletion failed
        $response = ['success' => false];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // entry_id not provided
    $response = ['success' => false];
    header('Content-Type: application/json');
    echo json_encode($response);
}
