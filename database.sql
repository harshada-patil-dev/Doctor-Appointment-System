-- Doctor Appointment System - Database
DB_NAME= :"doctor_appoinment";
USER_NAME =" localhost"
PASSWORD = " "
CREATE DATABASE IF NOT EXISTS doctor_appointment CHARACTER SET utf8mb4;
USE doctor_appointment;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  role ENUM('admin','doctor','patient') NOT NULL DEFAULT 'patient',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  description VARCHAR(255)
);

CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  department_id INT NOT NULL,
  specialization VARCHAR(100),
  fee DECIMAL(8,2) DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE RESTRICT
);

CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATE NOT NULL,
  appointment_time TIME NOT NULL,
  reason VARCHAR(255),
  status ENUM('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Default admin  (email: admin@clinic.com | password: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Administrator', 'admin@clinic.com', '$2y$12$lEuZX1iIzBNRHuhNPI83KOD91kNAFZ.QOld3OFAkSk.eKQIIjdRWq', 'admin');

INSERT INTO departments (name, description) VALUES
('Cardiology', 'Heart and blood vessel care'),
('Dermatology', 'Skin, hair and nails'),
('Pediatrics', 'Child health'),
('Orthopedics', 'Bones and joints');
