ALTER TABLE assessment_slots ADD COLUMN allow_student_uploads TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE poe_submissions ADD COLUMN uploaded_by INT NULL;
ALTER TABLE poe_submissions ADD CONSTRAINT fk_uploaded_by FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL;
