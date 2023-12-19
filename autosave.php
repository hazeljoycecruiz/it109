<?php
include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry_title = mysqli_real_escape_string($db, $_POST['entry_title']);
    $content = mysqli_real_escape_string($db, $_POST['content']);

    // Check if there is an existing entry with the same title in autosave_entries
    $check_query = "SELECT * FROM autosave_entries WHERE entry_title = '$entry_title'";
    $result = mysqli_query($db, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // If entry exists, update the content
        $update_query = "UPDATE autosave_entries SET content = '$content' WHERE entry_title = '$entry_title'";
        mysqli_query($db, $update_query);
    } else {
        // If entry does not exist, insert a new entry
        $insert_query = "INSERT INTO autosave_entries (entry_title, content) VALUES ('$entry_title', '$content')";
        mysqli_query($db, $insert_query);
    }
}