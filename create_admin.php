<?php
require_once 'config.php';

// Admin details
$name = "Admin";
$email = "admin@gmail.com";
$password = "Admin@123";
$phone = "9876543210";

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {

    // Check existing user
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {

        // Update existing user as admin
        $stmt = $pdo->prepare(
            "UPDATE users SET name=?, password=?, phone=?, role='admin' WHERE email=?"
        );

        $stmt->execute([$name, $hashedPassword, $phone, $email]);

    } else {

        // Create new admin
        $stmt = $pdo->prepare(
            "INSERT INTO users (name,email,password,phone,role)
             VALUES (?,?,?,?, 'admin')"
        );

        $stmt->execute([$name, $email, $hashedPassword, $phone]);
    }

    echo "<h2>Admin Created Successfully!</h2>";
    echo "Email: " . htmlspecialchars($email);
    echo "<br>Password: Admin@123";

} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>