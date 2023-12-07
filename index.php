<?php
include("connection.php");
include ("login.php");

if (isset($_POST['submit'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user) || empty($pass)) {
        echo "Username and password are required!";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO adminlogin (username, password) VALUES (?, ?)");
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $user, $hashedPassword);

        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div id="form">
    <h1>Login</h1>
    <form name="form" action="" onsubmit="return isValid()" method="POST">
        <label>Username: </label>
        <input type="text" id="user" name="user"></br></br>
        <label>Password: </label>
        <input type="password" id="pass" name="pass"></br></br>
        <input type="submit" id="btn" value="Login" name="submit"/>
    </form>
</div>

<script>
    function isValid() {
        var user = document.form.user.value;
        var pass = document.form.pass.value;
        if (user.length === 0 || pass.length === 0) {
            alert("Username and password fields are required!");
            return false;
        }
    }
</script>
</body>
</html>
