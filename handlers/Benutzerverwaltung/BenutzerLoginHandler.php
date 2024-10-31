<?php
session_start();
include 'db.php'; // Ensure db.php has your database connection setup

function handleLogin($username, $password) {
    global $db; // Assuming $db is an instance of your database connection (e.g., PDO)

    // Query to fetch user details by username
    $query = "SELECT user_id, vorname, nachname, username, passwort FROM user WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->execute([':username' => $username]);

    // Check if user exists
    if ($stmt->rowCount() === 0) {
        return ['error' => 'Login failed. No account found with that username.'];
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password (assuming it's hashed in the database)
    if (password_verify($password, $user['passwort'])) {
        // Set session variables on successful login
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['vorname'] = $user['vorname'];
        $_SESSION['nachname'] = $user['nachname'];

        // Return a success response
        return [
            'status' => 'success',
            'message' => 'Login successful!',
            'user_id' => $user['user_id'],
            'username' => $user['username']
        ];
    } else {
        // Password is incorrect
        return ['error' => 'Login failed. Incorrect password.'];
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = handleLogin($username, $password);

    if (isset($result['error'])) {
        echo $result['error']; // Show error message
    } else {
        header("Location: dashboard.php"); // Redirect to a dashboard or another page after login
        exit();
    }
}
?>