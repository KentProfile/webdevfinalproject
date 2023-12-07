<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "employee_management";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data and add the employee to the database
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $last_name = $_POST["last_name"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // Database connection (same as above)
    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO employees (first_name, middle_name, last_name, address, email, phone)
            VALUES ('$first_name', '$middle_name', '$last_name', '$address', '$email', '$phone')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: employee-list.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Employee</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #40E0D0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            text-align: center;
            padding: 20px;
        }
        form {
            margin-top: 10px, 10px, 10px, 10px;
            
            width: 400px;
            text-align: center;
           
            
        }
        input[type="text"], input[type="email"] {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
            
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Employee</h1>
        <form method="POST" action="">
            First Name: <input type="text" name="first_name" required><br>
            Middle Name: <input type="text" name="middle_name"><br>
            Last Name: <input type="text" name="last_name" required><br>
            Address: <input type="text"name="address" required><br>
            Email: <input type="email" name="email" required><br>
            Phone: <input type="text" name="phone"><br>
            <input type="submit" value="Add">
        </form>
        <a href="employee-list.php">Back to Employee List</a>
    </div>
</body>
</html>
