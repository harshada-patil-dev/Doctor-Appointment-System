<?php
require_once 'config.php';
$pageTitle = 'Patient Registration';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $pass    = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($name === '')                              $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email.';
    if (!preg_match('/^[0-9]{10}$/', $phone))      $errors[] = 'Phone must be 10 digits.';
    if (strlen($pass) < 6)                         $errors[] = 'Password must be at least 6 characters.';
    if ($pass !== $confirm)                        $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $chk = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $chk->execute([$email]);
        if ($chk->fetch()) {
            $errors[] = 'This email is already registered.';
        } else {
            $pdo->prepare('INSERT INTO users (name, email, password, phone, role) VALUES (?,?,?,?, "patient")')
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT), $phone]);
            flash('Registration successful! Please login.');
            redirect('login.php');
        }
    }
}
include 'includes/header.php';
?>
<div class="form-box">
  <h2>Patient Registration</h2>
  <?php foreach ($errors as $err): ?><div class="alert alert-error"><?= e($err) ?></div><?php endforeach; ?>
  <form method="post" data-validate>
    <label>Full Name</label>
    <input type="text" name="name" value="<?= e($_POST['name'] ?? '') ?>" required>
    <label>Email</label>
    <input type="email" name="email" value="<?= e($_POST['email'] ?? '') ?>" required>
    <label>Phone (10 digits)</label>
    <input type="text" name="phone" maxlength="10" value="<?= e($_POST['phone'] ?? '') ?>" required>
    <label>Password</label>
    <input type="password" name="password" minlength="6" required>
    <label>Confirm Password</label>
    <input type="password" name="confirm" required>
    <button class="btn" type="submit">Register</button>
    <p class="muted">Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>
<?php include 'includes/footer.php'; ?>
