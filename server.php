<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'it109');

if (function_exists("getJournalId") === FALSE) {

  function getJournalId($db, $user_id)
  {
    $journal_check_query = "SELECT journal_id FROM journal WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($db, $journal_check_query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $journal = mysqli_fetch_assoc($result);

    return $journal ? $journal['journal_id'] : null;
  }
}

//------------------REGISTER--------------------------
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) {
    array_push($errors, "Username is required");
  } else if (empty($email)) {
    array_push($errors, "Email is required");
  } else if (empty($password_1)) {
    array_push($errors, "Password is required");
  } else if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  } else if (strlen($password_1) < 12) {
    array_push($errors, "Password is Weak");
  } else if (!preg_match('/[!@#$%^&*]/', $password_1)) {
    array_push($errors, "Password must contain a Special Letter");
  } else if (!preg_match('/\d/', $password_1)) {
    array_push($errors, "Password must contain a Number");
  } else if (!preg_match('/[A-Z]/', $password_1)) {
    array_push($errors, "Password must contain an Uppercase Letter");
  } else if (!preg_match('/[a-z]/', $password_1)) {
    array_push($errors, "Password must contain a Lowercase Letter");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = password_hash($password_1, PASSWORD_DEFAULT); // Use password_hash to securely hash the password
    $username = mysqli_real_escape_string($db, $username); // Escape username

    $query = "INSERT INTO users (username, email, password) 
              VALUES('$username', '$email', '$password')";


    mysqli_query($db, $query);
    $user_id = mysqli_insert_id($db);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    mysqli_query($db, "INSERT INTO audit_log (table_name, action, user_id) VALUES ('users', 'register',  $user_id)");


    // $user_id = mysqli_insert_id($db);              // for triggers
    // mysqli_query($db, "INSERT INTO audit_log (table_name, action, record_id, user_id) VALUES ('entries', 'insert', $entry_id, $user_id)"); // for triggers

    header('location: index.php');
  }
}

// LOGIN USER
// if (isset($_POST['login_user'])) {
//   $username = mysqli_real_escape_string($db, $_POST['username']);
//   $password = mysqli_real_escape_string($db, $_POST['password']);

//   if (empty($username)) {
//   	array_push($errors, "Username is required");
//   }
//   if (empty($password)) {
//   	array_push($errors, "Password is required");
//   }

//   if (count($errors) == 0) {
//   	$password = md5($password);
//     $username = md5($username);
//   	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
//   	$results = mysqli_query($db, $query);
//   	if (mysqli_num_rows($results) == 1) {
//   	  //  $_SESSION['username'] = $username;
//   	  //  $_SESSION['success'] = "You are now logged in";
//   	  header('location: code.php');
//   	}else {
//   		array_push($errors, "Wrong username/password ");
//   	}
//   }
// }


//------------------LOG IN--------------------------
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = $_POST['password'];

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
      if (password_verify($password, $row['password'])) {
        // Set a session flag to indicate successful login
        $_SESSION['login_successful'] = true;
        // You can set other session variables if needed
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";

        // $user_id = $user_id = mysqli_insert_id($db);      // for triggers
        // mysqli_query($db, "INSERT INTO audit_log (table_name, action, record_id, user_id) VALUES ('entries', 'update', $user_id, $user_id)");  // for triggers     

        mysqli_query($db, "INSERT INTO audit_log (table_name, action, user_id) VALUES ('users', 'login', {$row['id']})");
        header('location: code.php');
      } else {
        array_push($errors, "Wrong username/password");
      }
    } else {
      array_push($errors, "User not found");
    }
  }
}






//------------------FORGET PASSWORD--------------------------
if (isset($_POST['reset_password'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) {
    array_push($errors, "Username is required");
  } else if (empty($email)) {
    array_push($errors, "Email is required");
  } else if (empty($password_1)) {
    array_push($errors, "Password is required");
  } else if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  } else if (strlen($password_1) < 12) {
    array_push($errors, "Password is Weak");
  } else if (!preg_match('/[!@#$%^&*]/', $password_1)) {
    array_push($errors, "Password must contain a Special Letter");
  } else if (!preg_match('/\d/', $password_1)) {
    array_push($errors, "Password must contain a Number");
  } else if (!preg_match('/[A-Z]/', $password_1)) {
    array_push($errors, "Password must contain an Uppercase Letter");
  } else if (!preg_match('/[a-z]/', $password_1)) {
    array_push($errors, "Password must contain a Lowercase Letter");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] != $username) {
      array_push($errors, "Username does not exists");
    }

    if ($user['email'] != $email) {
      array_push($errors, "email does not match");
    }
  }
  // if($password_1['password'] == $password){
  //   array_push($errors, "create password another");
  // }

  if (count($errors) == 0) {
    $password = password_hash($password_1, PASSWORD_DEFAULT); // Use password_hash to securely hash the password
    $username = mysqli_real_escape_string($db, $username); // Escape username

    // Fetch the user's ID before updating the password
    $user_check_query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    // Ensure that the user exists before proceeding
    if ($user) {
      $user_id = $user['id'];

      // Update the password
      $query = "UPDATE users  
              SET password = '$password'
              WHERE username = '$username'";
      mysqli_query($db, $query);

      // Update the audit log
      mysqli_query($db, "INSERT INTO audit_log (table_name, action, user_id) VALUES ('users', 'update password',  $user_id)");

      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      header('location: index.php');
    } else {
      // Handle the case where the user does not exist
      array_push($errors, "User not found");
    }
  }
}



//------------------Journal Title--------------------------

if (isset($_POST['submit_journal'])) {

  $journal_title = mysqli_real_escape_string($db, $_POST['journal_title']);
  $username = $_SESSION['username'];

  // Retrieve the user ID
  $user_check_query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  // Check if the user exists
  if ($user) {
    $user_id = $user['id'];

    // Check for existing journal titles
    $existing_journal_query = "SELECT journal_title FROM journal WHERE id='$user_id' AND journal_title='$journal_title'";
    $result = mysqli_query($db, $existing_journal_query);
    $existing_journal = mysqli_fetch_assoc($result);

    if ($existing_journal) {
      array_push($errors, "Journal title already exists");
    }

    if (count($errors) == 0) {
      // ... (your existing code for handling successful journal creation)
      $sql = "INSERT INTO journal (id, journal_title) VALUES ('$user_id', '$journal_title')";

      try {
        if (mysqli_query($db, $sql)) {
          $_SESSION['success'] = "Journal created successfully";
          header('location: new-entry.php'); // Redirect to the new-entry.php page
          exit(); // Add exit to stop further execution
        } else {
          throw new Exception("Error: " . $sql . "<br>" . mysqli_error($db));
        }
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  } else {
    // Handle the case where the user does not exist
    array_push($errors, "User not found");
  }
}




//------------------New Entry--------------------------



// New Entry
if (isset($_POST['submit_entry'])) {

  // Get user ID based on the session
  $username = $_SESSION['username'];

  // Retrieve the user ID
  $user_check_query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) {
    $user_id = $user['id'];
    // Get the current journal_id
    $journal_id = getJournalId($db, $user_id);

    if ($journal_id !== null) {
      $entry_title = mysqli_real_escape_string($db, $_POST['entry_title']);
      $content = mysqli_real_escape_string($db, $_POST['content']);

      // Insert data into the database
      $sql = "INSERT INTO entries (journal_id, entry_title, content, created_at) VALUES (?, ?, ?, NOW())";
      $stmt = mysqli_prepare($db, $sql);

      // Bind parameters
      mysqli_stmt_bind_param($stmt, "iss", $journal_id, $entry_title, $content);

      // Execute the statement
      if (mysqli_stmt_execute($stmt)) {
        echo "Entry saved successfully.";
      } else {
        echo "Error: " . mysqli_error($db);
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    } else {
      echo "Error: Journal ID not found for the user.";
    }
  } else {
    echo "Error: User ID not found in the session.";
  }
}

//------------------Delete Entry--------------------------

if (isset($_POST['delete_entry'])) {
  $entry_id = mysqli_real_escape_string($db, $_POST['entry_id']);

  // Check if the entry exists
  $entry_check_query = "SELECT * FROM entries WHERE entry_id = '$entry_id' LIMIT 1";
  $result = mysqli_query($db, $entry_check_query);
  $entry = mysqli_fetch_assoc($result);

  if ($entry) {
    // Get the journal ID for audit log
    $journal_id = $entry['journal_id'];

    // Delete the entry
    $delete_query = "DELETE FROM entries WHERE entry_id = '$entry_id'";
    mysqli_query($db, $delete_query);

    // Log the delete action
    mysqli_query($db, "INSERT INTO audit_log (table_name, action, user_id, journal_id) VALUES ('entries', 'delete', {$entry['user_id']}, $journal_id)");

    echo "Entry deleted successfully.";
  } else {
    echo "Error: Entry not found.";
  }
}
