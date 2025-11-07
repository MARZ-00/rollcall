<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "rollcall";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirmation = $_POST['passwordConfirmation'];

// Validate password match
if ($password !== $passwordConfirmation) {
    die("Passwords do not match.");
}

// Check if user already exists
$sql = "SELECT email FROM admin WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Email already registered.";
} else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $sql = "INSERT INTO admin (nama, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('You have been registered');</script>";
        header("Location: login.html");
        exit;
    
    } else {
        echo "Registration failed: " . $stmt->error;
    }
}

$conn->close();
?>
