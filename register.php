<?php
// Model
class User {
    private $name;
    private $email;
    private $password;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
}

// Controller
class UserController {
    private $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function register() {
        $name = $this->model->getName();
        $email = $this->model->getEmail();
        $password = $this->model->getPassword();

        if (empty($name) || empty($email) || empty($password)) {
            return "Please fill in all required fields.";
        } else {
            $host = "localhost";
            $username = "root";
            $db_password = "";
            $database = "your_database";

            if($email == "admin@admin.com") {
                return "ERROR-- Email can not be: 'admin@admin.com'";
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
                    $stmt->close();
                    $conn->close();
                    return "Registration successful!";
                } else {
                    $stmt->close();
                    $conn->close();
                    return "Registration failed. Please try again later.";
                }
            }
        }
    }
}

// View
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = new User($name, $email, $password);
    $controller = new UserController($user);

    $message = $controller->register();

    echo $message;
}
?>
