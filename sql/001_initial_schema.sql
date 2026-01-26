-- 001_initial_schema.sql

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Institution
CREATE TABLE IF NOT EXISTS institution (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    tvet_code VARCHAR(50),
    logo VARCHAR(255),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Users & Roles
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE -- 'Admin', 'Trainer', 'HOD', 'InternalVerifier', 'Student'
);

INSERT IGNORE INTO roles (name) VALUES ('Admin'), ('Trainer'), ('HOD'), ('InternalVerifier'), ('Student');

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150),
    phone VARCHAR(20),
    role_id INT NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- 3. Departments & Courses
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    head_user_id INT, -- HOD
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (head_user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    code VARCHAR(50) NOT NULL UNIQUE,
    department_id INT NOT NULL,
    level VARCHAR(50), -- Diploma, Certificate
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

-- 4. Cohorts & Classes
CREATE TABLE IF NOT EXISTS cohorts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL, -- e.g. "January 2024 Intake"
    start_date DATE,
    end_date DATE,
    is_active BOOLEAN DEFAULT 1
);

CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_code VARCHAR(50) NOT NULL UNIQUE, -- e.g. "ICT-JAN-24"
    course_id INT NOT NULL,
    cohort_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    FOREIGN KEY (cohort_id) REFERENCES cohorts(id) ON DELETE CASCADE
);

-- 5. Enrollments (Student -> Class)
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    class_id INT NOT NULL,
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    UNIQUE(user_id, class_id)
);

-- 6. Units of Competency (The Library)
CREATE TABLE IF NOT EXISTS units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_code VARCHAR(50) NOT NULL UNIQUE,
    unit_title VARCHAR(255) NOT NULL,
    category ENUM('Basic', 'Common', 'Core') NOT NULL,
    course_id INT NOT NULL,
    description TEXT,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- 7. Allocations (Trainer/IV -> Class/Unit)
CREATE TABLE IF NOT EXISTS unit_allocations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_id INT NOT NULL,
    class_id INT NOT NULL,
    trainer_user_id INT,
    verifier_user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (trainer_user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (verifier_user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 8. Assessment Framework
CREATE TABLE IF NOT EXISTS assessment_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_id INT NOT NULL,
    title VARCHAR(150) NOT NULL, -- e.g. "Written Assessment 1", "Practical Project 2"
    type ENUM('Written', 'Practical') NOT NULL,
    instructions TEXT,
    max_marks INT DEFAULT 100, -- Optional, for record
    sequence_order INT DEFAULT 1,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
);

-- 9. POE Submissions (The Evidence)
CREATE TABLE IF NOT EXISTS poe_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_user_id INT NOT NULL,
    assessment_slot_id INT NOT NULL,
    file_path VARCHAR(255), -- Relative to uploads dir
    file_type VARCHAR(50), -- pdf, docx, img
    status ENUM('Pending', 'Submitted', 'Rejected', 'Approved') DEFAULT 'Pending',
    version INT DEFAULT 1,
    submitted_at DATETIME,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_slot_id) REFERENCES assessment_slots(id) ON DELETE CASCADE
);

-- 10. Reviews & Approvals
CREATE TABLE IF NOT EXISTS poe_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    submission_id INT NOT NULL,
    reviewer_user_id INT NOT NULL,
    role_at_time VARCHAR(50), -- 'Trainer', 'InternalVerifier', 'Admin'
    decision ENUM('Approved', 'Rejected') NOT NULL,
    comments TEXT,
    reviewed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (submission_id) REFERENCES poe_submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewer_user_id) REFERENCES users(id)
);

SET FOREIGN_KEY_CHECKS = 1;

-- Default Admin User (Password: admin123)
-- Hash generated via password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO users (email, password_hash, full_name, role_id) 
SELECT 'admin@cbet.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator', 1 
WHERE NOT EXISTS (SELECT 1 FROM users WHERE email = 'admin@cbet.local');
