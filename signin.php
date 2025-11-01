<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $input = trim($_POST["username"]);
    $password = $_POST["password"];

    // Prepare SQL to match either email or username
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Login success
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['firstname'];
        header("Location: index-page.html"); // ✅ redirect to a dashboard
        exit();
    } else {
        // Login failed
        echo "<script>alert('Invalid credentials!'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>