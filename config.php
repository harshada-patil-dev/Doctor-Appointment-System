<?php
// ---------- Database & session configuration ----------
session_start();

define('BASE_URL', '/doctor_appointment');   // change if you rename the folder

$host = 'localhost';
$db   = 'doctor_appointment';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// ---------- Helper functions ----------
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function flash($msg, $type = 'success') { $_SESSION['flash'] = ['msg' => $msg, 'type' => $type]; }

function redirect($path) { header('Location: ' . BASE_URL . '/' . $path); exit; }

function require_role($role) {
    if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== $role) {
        redirect('login.php');
    }
}

function time_slots() {
    $slots = [];
    for ($t = strtotime('09:00'); $t <= strtotime('16:30'); $t += 1800) {
        $slots[] = date('H:i', $t);
    }
    return $slots;
}

const STATUSES = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];

// Update appointment status (used by admin and doctor pages)
function handle_status_update(PDO $pdo, $doctorId = null) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
        $id     = (int)$_POST['appointment_id'];
        $status = $_POST['status'] ?? '';
        if (in_array($status, STATUSES)) {
            $sql = 'UPDATE appointments SET status = ? WHERE id = ?';
            $params = [$status, $id];
            if ($doctorId) { $sql .= ' AND doctor_id = ?'; $params[] = $doctorId; }
            $pdo->prepare($sql)->execute($params);
            flash('Appointment status updated.');
        }
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}
