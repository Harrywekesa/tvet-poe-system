-- 002_marks_schema.sql

SET FOREIGN_KEY_CHECKS = 0;

-- 1. New Table: unit_topics (Elements)
CREATE TABLE IF NOT EXISTS unit_topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    unit_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    weight_percentage DECIMAL(5,2) DEFAULT 0.00, -- e.g. 20.00 for 20%
    sequence_order INT DEFAULT 1,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
);

-- 2. Modify Table: assessment_slots
-- Add topic_id to link assessments to specific topics.

-- Check if column exists strictly is hard in pure SQL script without procedures in MySQL < 8.0 sometimes,
-- but since we know this is a fresh addition, we attempt ALTER.
-- If it fails, it means it was partially run.
-- We'll use a procedure to make it idempotent if possible, or just simple ALTER for now as requested.

ALTER TABLE assessment_slots 
ADD COLUMN topic_id INT NULL AFTER unit_id,
ADD CONSTRAINT fk_assessment_topic FOREIGN KEY (topic_id) REFERENCES unit_topics(id) ON DELETE CASCADE;

-- 3. Modify Table: units
-- Add assessment_level for Trainer-defined weighting logic
ALTER TABLE units
ADD COLUMN assessment_level ENUM('Level 4', 'Level 5', 'Level 6') NOT NULL DEFAULT 'Level 6';

-- 4. New Table: student_marks
CREATE TABLE IF NOT EXISTS student_marks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    assessment_slot_id INT NOT NULL,
    marks_obtained DECIMAL(5,2) NOT NULL,
    graded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    graded_by_user_id INT, -- Trainer who graded it
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_slot_id) REFERENCES assessment_slots(id) ON DELETE CASCADE,
    UNIQUE KEY unique_student_assessment (student_id, assessment_slot_id)
);

-- 5. New Table: marksheet_status (Approval Workflow)
CREATE TABLE IF NOT EXISTS marksheet_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    unit_id INT NOT NULL,
    status ENUM('Draft', 'Submitted_to_HOD', 'HOD_Rejected', 'HOD_Approved', 'IQS_Rejected', 'IQS_Approved') DEFAULT 'Draft',
    
    -- Trainer Submission
    submitted_at DATETIME NULL,
    submitted_by INT, -- Trainer ID
    
    -- HOD Action
    hod_action_at DATETIME NULL,
    hod_user_id INT,
    hod_comments TEXT,
    
    -- IQS Action
    iqs_action_at DATETIME NULL,
    iqs_user_id INT,
    iqs_comments TEXT,
    
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (unit_id) REFERENCES units(id) ON DELETE CASCADE
);

SET FOREIGN_KEY_CHECKS = 1;
