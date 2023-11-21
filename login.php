<?php
// Database configuration
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "your_database"; // Change to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check against database using prepared statements
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password']) && $email==$user['email']) {
            // Valid credentials, redirect to welcome.php
            if($email=="admin@admin.com")
                echo "Admin Logged In!";
            else
                echo "User Logged In!";
        } else {
            // Invalid password
            echo "Invalid email or password";
        }
    } else {
        // Invalid email
        echo "Invalid email or password";
    }
}

$conn->close();
?>
