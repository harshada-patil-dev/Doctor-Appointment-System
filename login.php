<?php
require_once 'config.php';
$pageTitle = 'Login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($pass, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']];
        redirect($user['role'] . '/dashboard.php');
    } else {
        $error = 'Invalid email or password.';
    }
}
include 'includes/header.php';
?>
<div class="form-box">
  <h2>Login</h2>
  <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Login</button>
    <p class="muted">New patient? <a href="register.php">Register here</a></p>
    <p class="muted small">Admin demo: admin@clinic.com / admin123</p>
  </form>
</div>
<?php include 'includes/footer.php'; ?>
