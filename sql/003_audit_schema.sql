CREATE TABLE IF NOT EXISTS audit_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_id INT NOT NULL,
    class_id INT NOT NULL,
    verifier_user_id INT NOT NULL,
    sample_size INT NOT NULL,
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (unit_id) REFERENCES units(id),
    FOREIGN KEY (class_id) REFERENCES classes(id),
    FOREIGN KEY (verifier_user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS audit_samples (
    id INT AUTO_INCREMENT PRIMARY KEY,
    audit_session_id INT NOT NULL,
    student_user_id INT NOT NULL,
    status ENUM('Pending', 'Compliant', 'Non-Compliant') DEFAULT 'Pending',
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (audit_session_id) REFERENCES audit_sessions(id) ON DELETE CASCADE,
    FOREIGN KEY (student_user_id) REFERENCES users(id)
);
