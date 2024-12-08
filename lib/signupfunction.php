<?php
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from the form
    $username = $_POST['username'];
    $email = $_POST['email']; // Get the email from the form
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'customer'; // Default role for new users

    // Check if passwords match
    if ($password !== $confirm_password) {
        header('Location: register.html?error=Passwords do not match');
        exit();
    }

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        header('Location: register.html?error=Username already taken');
        exit();
    }

    // Insert the new user into the database (without password hashing)
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $role);

    if ($stmt->execute()) {
        // Redirect to login page if registration is successful
        header('Location: ./signin.php');
        exit();
    } else {
        // If there is a database error
        header('Location: register.html?error=Database error');
        exit();
    }
}
?>
