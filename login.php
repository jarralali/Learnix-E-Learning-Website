<?php

class DatabaseConnectionFactory {
    public static function createConnection() {
        $servername = "localhost";
        $username = "root"; // Change to your MySQL username
        $password = ""; // Change to your MySQL password
        $dbname = "your_database"; // Change to your MySQL database name

        return new mysqli($servername, $username, $password, $dbname);
    }
}

class Authentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticate($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password']) && $email == $user['email']) {
                // Valid credentials
                if ($email == "admin@admin.com") {
                    return "Admin Logged In!";
                } else {
                    return "User Logged In!";
                }
            } else {
                // Invalid password
                return "Invalid email or password";
            }
        } else {
            // Invalid email
            return "Invalid email or password";
        }
    }
}

// Usage of the file
$databaseConnection = DatabaseConnectionFactory::createConnection();
$authentication = new Authentication($databaseConnection);

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $resultMessage = $authentication->authenticate($email, $password);

    echo $resultMessage;
}

$databaseConnection->close();

?>
