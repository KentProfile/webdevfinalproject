<?php

// Check if username and password are set
if (isset($_POST['username']) && isset($_POST['password'])) {

  // Replace with your actual user validation logic
  // This example checks against hardcoded values for simplicity
  if ($_POST['username'] === 'user' && $_POST['password'] === 'password') {
    echo "Welcome back, " . $_POST['username'] . "!";
  } else {
    echo "Invalid username or password.";
  }

} #else {
  #echo "Missing username or password.";
#}

?>
