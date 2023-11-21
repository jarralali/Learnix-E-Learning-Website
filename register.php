<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"]; // Make sure "name" field is available in your HTML form
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all required fields.";
    } else {
        $host = "localhost";
        $username = "root";
        $db_password = ""; // Renamed to avoid conflict with form field variable
        $database = "your_database";

        if($email == "admin@admin.com") {
            echo "ERROR-- Email can nt be: 'admin@admin.com'";
        } else {
            $conn = new mysqli($host, $username, $db_password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Registration failed. Please try again later.";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>
