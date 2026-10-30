<?php
require_once 'config.php';
$pageTitle = 'Home - Doctor Appointment System';
$departments = $pdo->query('SELECT * FROM departments ORDER BY name')->fetchAll();
$doctors = $pdo->query('SELECT d.*, u.name, dep.name AS department
                        FROM doctors d JOIN users u ON u.id = d.user_id
                        JOIN departments dep ON dep.id = d.department_id
                        ORDER BY u.name')->fetchAll();
include 'includes/header.php';
?>
<section class="hero">
  <h1>Book Your Doctor Appointment Online</h1>
  <p>Choose a department, pick a doctor and select a time that suits you.</p>
  <?php if (empty($_SESSION['user'])): ?>
    <a class="btn" href="register.php">Register as Patient</a>
    <a class="btn btn-outline" href="login.php">Login</a>
  <?php elseif ($_SESSION['user']['role'] === 'patient'): ?>
    <a class="btn" href="patient/book.php">Book Appointment</a>
  <?php endif; ?>
</section>

<h2>Our Departments</h2>
<div class="grid">
  <?php foreach ($departments as $d): ?>
    <div class="card"><h3><?= e($d['name']) ?></h3><p><?= e($d['description']) ?></p></div>
  <?php endforeach; ?>
</div>

<h2>Our Doctors</h2>
<div class="grid">
  <?php foreach ($doctors as $d): ?>
    <div class="card">
      <h3>Dr. <?= e($d['name']) ?></h3>
      <p><strong><?= e($d['department']) ?></strong> &middot; <?= e($d['specialization']) ?></p>
      <p>Fee: &#8377;<?= number_format($d['fee'], 2) ?></p>
    </div>
  <?php endforeach; ?>
  <?php if (!$doctors): ?><p class="empty">No doctors added yet.</p><?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
