<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $address = trim($_POST["address"]);
    $zipcode = trim($_POST["zipcode"]);
    $state = $_POST["state"];
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $farm_type = $_POST["farmtype"]; 
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // hashed for security

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, address, zipcode, state, username, email, phone, farm_type, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $firstname, $lastname, $address, $zipcode, $state, $username, $email, $phone, $farm_type, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href = 'signin.html';</script>";
    } else {
        echo "<script>alert('Signup failed: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
