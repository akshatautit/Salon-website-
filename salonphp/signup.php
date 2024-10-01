<?php
session_start();
include '_dbconnect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already registered. Please log in.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $insert_query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($insert_stmt->execute()) {
        // Set session variables or redirect as needed
        $_SESSION['user_id'] = $conn->insert_id; // Get the ID of the newly inserted user
        $_SESSION['user_email'] = $email;
        header("Location: index.html"); // Redirect to homepage
        exit();
    } else {
        echo "Error: Could not register user.";
        exit();
    }
}
?>
