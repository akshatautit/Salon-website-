<?php
session_start(); // Start the session
include '_dbconnect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Get the email from form submission
    $password = $_POST['password']; // Get the password from form submission

    // Basic validation
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit();
    }

    // Prepare and execute the SQL query to check user credentials
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email); // Bind the email parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the given email exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc(); // Fetch the user data

        // Verify password (assuming passwords are hashed)
        if (password_verify($password, $user['password'])) {
            // Set session variables for logged-in user
            $_SESSION['user_id'] = $user['sno']; // Use the correct column for user ID
            $_SESSION['user_email'] = $user['email'];

            // Redirect to index.html
            header("Location: index.html"); // Redirect to homepage
            exit(); // Stop executing the script after redirection
        } else {
            echo "Invalid password."; // Handle incorrect password
            exit();
        }
    } else {
        echo "No user found with that email."; // Handle no user found
        exit();
    }
}
?>
