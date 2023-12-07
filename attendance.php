<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "empattendance";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to record attendance
function recordAttendance($conn, $image, $type)
{
    $currentTime = date("H:i:s");

    switch ($type) {
        case 'AM_IN':
            $setTime = '09:00:00';
            $lateColumn = 'am_late';
            break;

        case 'AM_OUT':
            $setTime = '12:00:00';
            $undertimeColumn = 'am_undertime';
            break;

        case 'PM_IN':
            $setTime = '13:00:00';
            $lateColumn = 'pm_late';
            break;

        case 'PM_OUT':
            $setTime = '20:00:00';
            $undertimeColumn = 'pm_undertime';
            break;

        default:
            return;
    }

    if ($currentTime > $setTime) {
        $lateTime = date("H:i:s", strtotime($currentTime) - strtotime($setTime));
        $sql = "INSERT INTO attendance (image, $lateColumn) VALUES ('$image', '$lateTime')";
    } elseif ($currentTime < $setTime && isset($undertimeColumn)) {
        $undertime = date("H:i:s", strtotime($setTime) - strtotime($currentTime));
        $sql = "INSERT INTO attendance (image, $undertimeColumn) VALUES ('$image', '$undertime')";
    } else {
        // Log the attendance without any late or undertime
        $column = strtolower($type);
        $sql = "INSERT INTO attendance (image, $column) VALUES ('$image', '$currentTime')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Attendance recorded successfully";
    } else {
        echo "Error recording attendance: " . $conn->error;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle image upload
    $image = $_FILES["camera"]["tmp_name"];
    $imageData = addslashes(file_get_contents($image));

    // Check which button was clicked
    if (isset($_POST['am_in'])) {
        recordAttendance($conn, $imageData, 'AM_IN');
    } elseif (isset($_POST['am_out'])) {
        recordAttendance($conn, $imageData, 'AM_OUT');
    } elseif (isset($_POST['pm_in'])) {
        recordAttendance($conn, $imageData, 'PM_IN');
    } elseif (isset($_POST['pm_out'])) {
        recordAttendance($conn, $imageData, 'PM_OUT');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center the form content */
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        video {
            width: 100%; /* Make the video element take the full width */
            margin-bottom: 20px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <!-- Camera input for capturing images -->
        <label for="camera">Capture Photo:</label>
        <video id="camera" width="640" height="480" autoplay></video>
        <br>
        <!-- Button for capturing and recording -->
        <button type="button" id="captureButton">Capture & Record (PM_IN)</button>

        <!-- JavaScript to access the user's camera and handle capturing -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var video = document.getElementById('camera');
                var captureButton = document.getElementById('captureButton');

                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (stream) {
                        video.srcObject = stream;
                    })
                    .catch(function (error) {
                        console.log('Error accessing the camera: ', error);
                    });

                captureButton.addEventListener('click', function () {
                    var canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    var context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    var imageData = canvas.toDataURL('image/jpeg');

                    // Set the image data in a hidden input field for form submission
                    var hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'capturedImage';
                    hiddenInput.value = imageData;
                    document.forms[0].appendChild(hiddenInput);

                    // Submit the form
                    document.forms[0].submit();
                });
            });
        </script>

        <!-- Buttons for other attendance types -->
        <button type="submit" name="am_in">AM_IN</button>
        <button type="submit" name="am_out">AM_OUT</button>
        <button type="submit" name="pm_out">PM_OUT</button>
    </form>
</body>
</html>
